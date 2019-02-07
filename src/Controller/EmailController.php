<?php

namespace App\Controller;

use App\Entity\Record;
use App\Form\RecordType;
use App\Utils\Emailer;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\RecordRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("email")
 * @Security("has_role('ROLE_ADMIN')")
 */
class EmailController extends AbstractController
{
    /**
     * @Route("/", name="email_index", methods={"GET"} )
     */
    public function index( RecordRepository $recordRepository, PaginatorInterface $paginator, Request $request )
    {
        $records = $recordRepository->findBy([], ['timein' => 'DESC']);

        // Paginate the results of the query
        $records = $paginator->paginate(
            // Doctrine Query, not results
            $records,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );

        // Render the twig view
        return $this->render('emails/index.html.twig', ['records' => $records] );
    }

    /**
     * @Route("/new", name="email_new", methods={"POST"} )
     */
    public function new(Request $request)
    {
        $record = new Record();

        $record->setTimein( new \DateTime() );
        $record->setTimeout( new \DateTime() );
        $record->setSent(false);

        if( $this->isCsrfTokenValid('new'.$record->getId(), $request->request->get('_token')) )
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($record);
            $entityManager->flush();
    
            $this->addFlash(
                'notice',
                "Data has been successfully recorded."
            );
        }
        else
        {
            $this->addFlash(
                'error',
                "csrf_token is not valid, please validate your csrf_token."
            );
        }

        return $this->redirectToRoute('email_index');
    }

    /**
     * @Route("/{id}/send", name="email_send" )
     */
    public function send( Emailer $emailer, Record $record )
    {
        $entityManager = $this->getDoctrine()->getManager();

        $subject = 'Time in for ' . $record->getTimein()->format('F d Y');
        $setTo = 'noreply@paularity.com';
        // $emailTo = 'c.decembrana@axesscom.com';
        $emailTo = 'r.besitulo@axesscom.com';
        $date = $record->getTimein()->format('F d Y');
        $time = $record->getTimein()->format('h:i a');
        $complete_date_format = $record->getTimein()->format('h:i a, l, F d Y');
        $renderedView = $this->renderView( 'emails/template.html.twig', ['date' => $date, 'time' => $time ]);
        
        try 
        {
            $emailer->sendTimecard( $subject, $emailTo, $setTo, $renderedView );

            $record->setSent(true);

            $entityManager->flush();

            $this->addFlash(
                'notice',
                "Email was successfully sent to {$emailTo} @ {$complete_date_format}."
            );
        } 
        catch (\Throwable $th) 
        {
            $this->addFlash(
                'error',
                'There was a problem sending email!'
            );
        }

        return $this->redirectToRoute('email_index');
    }

    /**
     * @Route( "/edit?id={id}", name="email_edit", methods={"GET","POST"} )
     */
    public function edit(Request $request, Record $record)
    {
        $form = $this->createForm(RecordType::class, $record);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) 
        {
            if( $this->isCsrfTokenValid('update', $request->request->get('_token')) )
            {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash(
                    'notice',
                    "Record was successfully updated."
                );
    
                return $this->redirectToRoute('email_index', [
                    'id' => $record->getId(),
                ]);
            }
        }

        return $this->render('emails/edit.html.twig', [
            'record' => $record,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route( "/delete?id={id}", name="email_delete", methods={"GET","POST"} )
     */
    public function delete( Record $record )
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($record);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            "Record was successfully deleted."
        );

        return $this->redirectToRoute('email_index');
    }

}