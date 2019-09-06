<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 24/07/2019
 * Time: 09:58
 */

namespace App\Controller;


use App\Entity\Booking;
use App\Service\OrderNumber;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class SummaryController extends AbstractController
{
    /**
     * @Route("/recapitulatif", name="recapitulatif", methods={"GET", "POST"})
     */
    public function summary(SessionInterface $session, Request $request, \Swift_Mailer $mailer, OrderNumber $orderNumber)
    {
        /** @var Booking $booking */
        $booking = $session->get('booking');

        if(!$booking){
            throw new NotFoundHttpException();
        }

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

                $orderNumber->defineOrderNumber($booking);

                // Enregistrement en BDD
                $entityManager = $this->getDoctrine()->getManager();

                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($booking);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();


                // TODO faire le template du mail de confirmation

                // Create a message
                $message = (new \Swift_Message('Confirmation de paiement de vos billets pour le musée du Louvre'));

                $cid = $message->embed(\Swift_Image::fromPath("images/louvrelogo.png"));
                $message
                    ->setFrom(['no-reply@louvre.fr' => 'Musée du Louvre'])
                    ->setTo([$booking->getEmail() => 'Client'])
                    ->setBody($this->renderView('email.html.twig',array('booking' => $booking, 'cid' => $cid)), 'text/html');

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