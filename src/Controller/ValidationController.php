<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ValidationController extends AbstractController
{
    /**
     * @Route("/validation", name="validation")
     */
    public function index(SessionInterface $session)
    {
        $booking = $session->get('booking');


        if(!$booking){
            throw new NotFoundHttpException();
        }

        $session->remove('booking');

        return $this->render('validation.html.twig', ['booking'=>$booking]);
    }
}
