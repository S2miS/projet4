<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 18/06/2019
 * Time: 17:29
 */

namespace App\Controller\Home;


use App\Repository\PriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function home(PriceRepository $priceRepository){
        $prices= $priceRepository->findOneById(1);
        return $this->render('homepage.html.twig', [
            'prices'=> $prices
        ]);
    }
}