<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\CalendarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\AreaChart;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @IsGranted("ROLE_USER")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage", methods={"GET"})
     */    
    public function index( RecordRepository $recordRepository ) 
    {
        $records = $recordRepository->findBy([], ['timein' => 'DESC']);

        $time_in_arr = [];

        //add header to column
        array_push( $time_in_arr, [['label' => 'Date', 'type' => 'date'], ['label' => 'Attendance', 'type' => 'number']] );

        foreach ($records as $record) 
        {            
            $time_in = strtotime(date_format($record->getTimeIn(),"H:i:s"));
            $time_in = date("g.i", strtotime(date_format($record->getTimeIn(),"H:i:s")) );                                         
            
            if( $time_in < 10.05 )
            {
                array_push($time_in_arr, [ $record->getTimeIn(), 1 ] );
            }            
            else if( $time_in > 10.05 )
            {
                array_push($time_in_arr, [ $record->getTimeIn(), -1 ] );
            }
        }

        $cal = new CalendarChart();
        $cal->getData()->setArrayToDataTable( $time_in_arr );
        $cal->getOptions()->setTitle('Attendance');
        $cal->getOptions()->setHeight(200);
        $cal->getOptions()->setWidth(1000);

        //return to views
        return $this->render('dashboard/index.html.twig', array('calendarChart' => $cal) );
    }
}
