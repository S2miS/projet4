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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookingFormController extends AbstractController
{
    /**
     * @Route("/votre-commande", name="booking_form", methods={"GET", "POST"})
     */
    public function booking(Request $request){
        $booking= new Booking();
        $form= $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();
            return $this->redirectToRoute('booking_form', [
                'booking'=>$booking
            ]);
        }
        return $this->render('bookingForm.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}