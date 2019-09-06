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
     * @var TicketPrice
     */
    private $ticketPrice;

    public function __construct(TicketPrice $ticketPrice) {


        $this->ticketPrice = $ticketPrice;
    }

    public function nbTickets (Booking $booking) {
        for ($i = 1; $i <= $booking->getTicketNumber(); $i++){
            $booking->addTicket(new Ticket());
        }
    }

    public function computePrice (Booking $booking) {
        foreach ($booking->getTickets() as $ticket){
            $price=$this->ticketPrice->priceCheck($ticket);
            $ticket->setTicketPrice($price);
            $booking->addTicket($ticket);
            $booking->incrementOrderPrice($price);
        }
    }
}