<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 24/07/2019
 * Time: 09:58
 */

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Ticket;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SummaryController extends AbstractController
{
    /**
     * @Route("/recapitulatif/{id}", name="recapitulatif", methods={"GET", "POST"})
     */
    public function summary(Booking $booking){
        return $this->render('summary.html.twig', array('booking'=>$booking));
    }
}