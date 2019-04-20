<?php

namespace FServicios\WorkoutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use FServicios\WorkoutBundle\Entity\workout;

/**
 * @Route("/workout")
 */

class DefaultController extends Controller
{
    /**
     * @Route("/", name="workout_index")    
     * @Template("")
     */
    public function indexAction()
    {
        
        $workouts = new workout();
        $workouts->setActivity('yoga');
        $workouts->setHours(1);
        $workouts->setOccurrenceDate(new \DateTime());

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($workouts);

        $em->flush();

        return array();
    }
}
