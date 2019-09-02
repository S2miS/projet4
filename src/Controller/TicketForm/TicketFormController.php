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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TicketFormController extends AbstractController
{
    /**
     * @Route("/vos-tickets", name="ticket_form", methods={"GET", "POST"})
     */
    public function ticket(Request $request, TicketTypeHandler $handler, SessionInterface $session){
        $booking = $session->get('booking');

        if(!$booking){
            throw new NotFoundHttpException();
        }

        $form= $this->createForm( CollectionType::class, $booking->getTickets(), [
            'entry_type'=>TicketType::class
        ] );
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $handler->computePrice($booking);
            return $this->redirectToRoute('recapitulatif');
        }
        return $this->render('ticketForm.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}