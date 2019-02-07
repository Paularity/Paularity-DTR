<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("users")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"} )
     */
    public function index( UserRepository $UserRepository, PaginatorInterface $paginator, Request $request )
    {
        $users = $UserRepository->findAll();

        // Paginate the results of the query
        $users = $paginator->paginate(
            // Doctrine Query, not results
            $users,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );

        // Render the twig view
        return $this->render('users/index.html.twig', ['users' => $users] );
    }

}