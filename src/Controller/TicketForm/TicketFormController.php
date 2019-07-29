<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 25/06/2019
 * Time: 17:18
 */

namespace App\Controller\TicketForm;


use App\Entity\Booking;
use App\Entity\Ticket;
use App\Form\Handler\TicketTypeHandler;
use App\Form\TicketType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TicketFormController extends AbstractController
{
    /**
     * @Route("/vos-tickets/{id}", name="ticket_form", methods={"GET", "POST"})
     */
    public function ticket(Request $request, Booking $booking, TicketTypeHandler $handler){
        $tickets= $handler->nbTickets($booking);
        $form= $this->createForm( CollectionType::class, $tickets, [
            'entry_type'=>TicketType::class
        ] );
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $handler->givePriceAndFlush($tickets, $booking);
            return $this->redirectToRoute('recapitulatif', array('id'=>$booking->getId()));
        }
        return $this->render('ticketForm.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}