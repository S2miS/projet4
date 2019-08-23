<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 08/07/2019
 * Time: 14:08
 */

namespace App\Service;

use App\Entity\Price;
use App\Entity\Ticket;
use App\Entity\Booking;
use App\Repository\PriceRepository;
use Doctrine\ORM\EntityManagerInterface;

class TicketPrice{


    /**
     * @var PriceRepository
     */
    private $priceRepository;

    public function __construct(PriceRepository $priceRepository){


        $this->priceRepository = $priceRepository;
    }


    /**
     * @param Ticket $ticket
     * @param Booking $booking
     * @return float|int
     *
     *
     * TODO   voir comment virer le parametre $booking de cette methode
     */
    public function priceCheck(Ticket $ticket, Booking $booking) {
        $prices= $this->priceRepository->findPrices();

        $age= $ticket->getBirthday()->diff($booking->getVisitDay())->y;
        $discount= $ticket->getDiscount();
        $ticketType= $booking->getOrderType();
        $price=0;
        $normalPrice=$prices->getNormal();
        if($age < 4){
            $price=$prices->getFree();
        }
        elseif ($age >= 4 && $age < 12) {
            $price=$prices->getChild();
        }
        elseif ($age >= 12 && $age < 60) {
            $price=$prices->getNormal();
        }
        elseif ($age >= 60) {
            $price=$prices->getSenior();
        }
        elseif ($discount===true && $price>$normalPrice){
            $price=$prices->getDiscount();
        }
        if($ticketType===false){
            $price= $price /2;
        }
        return $price;
    }
}