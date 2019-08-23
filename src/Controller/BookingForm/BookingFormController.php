<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 25/06/2019
 * Time: 17:18
 */

namespace App\Controller\BookingForm;


use App\Entity\Booking;
use App\Form\BookingType;
use App\Service\OrderNumber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BookingFormController extends AbstractController
{
    /**
     * @Route("/votre-commande", name="booking_form", methods={"GET", "POST"})
     */
    public function booking(Request $request, OrderNumber $orderNumber, SessionInterface $session){
        $booking= new Booking();
        $form= $this->createForm(BookingType::class, $booking);
        $orderNumber->defineOrderNumber($booking);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $session->set('booking', $booking);
            return $this->redirectToRoute('ticket_form');
        }
        return $this->render('bookingForm.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}