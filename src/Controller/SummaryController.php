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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class SummaryController extends AbstractController
{
    /**
     * @Route("/recapitulatif", name="recapitulatif", methods={"GET", "POST"})
     */
    public function summary(SessionInterface $session, Request $request, \Swift_Mailer $mailer)
    {
        $booking = $session->get('booking');

        if ($request->isMethod("POST")) {
            \Stripe\Stripe::setApiKey('sk_test_GKohdNqZdj89Jwas3H9gVz7z00HPQmjdqZ');

            $token = $request->request->get("stripeToken");

            // Create a charge: this will charge the user's card
            try {
                $charge = \Stripe\Charge::create(array(
                    "amount" => $booking->getOrderPrice() * 100, // Amount in cents
                    "currency" => "eur",
                    "source" => $token,
                    "description" => "Paiement Stripe - Musée du Louvre"
                ));
                $this->addFlash("success", "Paiement effectué");

                // Enregistrement en BDD
                $entityManager = $this->getDoctrine()->getManager();

                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($booking);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                // TODO faire le template du mail de confirmation

                // Create a message
                $message = (new \Swift_Message('Confirmation de paiement de vos billets pour le musée du Louvre'))
                    ->setFrom(['thegeekization@gmail.com' => 'Musée du Louvre'])
                    ->setTo(['simbox94@yahoo.fr' => 'Client'])
                    ->setBody('Nous confirmons l\'achat de vos billets pour le musée du Louvre, bonne visite.' );

                // Send the message
                $result = $mailer->send($message);
                return $this->redirectToRoute('validation');

            } catch (\Stripe\Error\Card $e) {

                $this->addFlash("error", "Paiement refusé, veuillez réessayer");
            }
        }


        return $this->render('summary.html.twig', array('booking' => $booking));
    }
}