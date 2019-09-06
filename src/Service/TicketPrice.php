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

class TicketPrice
{

    const AGE_CHILD = 4;
    const AGE_NORMAL = 12;
    const AGE_SENIOR = 60;

    /**
     * @var PriceRepository
     */
    private $priceRepository;

    public function __construct(PriceRepository $priceRepository)
    {


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
    public function priceCheck(Ticket $ticket)
    {
        $booking = $ticket->getBooking();
        $prices = $this->priceRepository->findPrices();

        $age = $ticket->getBirthday()->diff($booking->getVisitDay())->y;
        $discount = $ticket->getDiscount();
        $ticketType = $booking->getOrderType();


        if ($age < TicketPrice::AGE_CHILD) {
            $price = $prices->getFree();
        } elseif ($age < TicketPrice::AGE_NORMAL) {
            $price = $prices->getChild();
        } elseif ( $age < TicketPrice::AGE_SENIOR) {
            $price = $prices->getNormal();
        } else {
            $price = $prices->getSenior();
        }


        if($discount === true && $price > $prices->getDiscount()) {
            $price = $prices->getDiscount();
        }
        if ($ticketType === false) {
            $price = $price * Price::REDUCE_COEEF;
        }
        return $price;
    }
}