<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 02/07/2019
 * Time: 17:31
 */

namespace App\Form\Handler;

use App\Entity\Booking;
use App\Entity\Ticket;
use App\Service\TicketPrice;
use Doctrine\Common\Persistence\ObjectManager;

class TicketTypeHandler
{
    /**
     * @var ObjectManager
     */
    private $objectManager;
    /**
     * @var TicketPrice
     */
    private $ticketPrice;

    public function __construct(ObjectManager $objectManager, TicketPrice $ticketPrice) {

        $this->objectManager = $objectManager;
        $this->ticketPrice = $ticketPrice;
    }

    public function nbTickets (Booking $booking) {
        $nb= $booking->getTicketNumber();
        $tickets= [];
        for ($i = 1; $i <= $nb; $i++){
            $tickets[]= new Ticket();
        }
        return $tickets;
    }

    public function givePriceAndFlush ($ticket, Booking $booking) {
        foreach ($ticket as $t){
            $price=$this->ticketPrice->priceCheck($t, $booking);
            $t->setTicketPrice($price);
            $booking->addTicket($t);
            $booking->setOrderPrice($price);
            $this->objectManager->persist($booking);
        }
        $this->objectManager->flush();
    }
}