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

class TicketTypeHandler
{
    public function nbTickets (Booking $booking) {
        $nb= $booking->getTicketNumber();
        $tickets= [];
        for ($i = 1; $i <= $nb; $i++){
            $tickets[]= new Ticket();
        }
        return $tickets;
    }
}