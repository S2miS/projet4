<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 24/07/2019
 * Time: 10:45
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StripePayementController extends AbstractController
{
    /**
     * @Route("/paiement", name="paiement", methods={"GET", "POST"})
     */
    public function summary(){

        \Stripe\Stripe::setApiKey('sk_test_GKohdNqZdj89Jwas3H9gVz7z00HPQmjdqZ');

        $token = $_POST['stripeToken'];
        $charge = \Stripe\Charge::create([
            'amount' => 100,
            'currency' => 'eur',
            'description' => 'Achat billet',
            'source' => $token,
        ]);
        return $this->render('payement.html.twig');
    }
}