<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 16/07/2019
 * Time: 17:56
 */

namespace App\Service;

use App\Entity\Booking;
use Ramsey\Uuid\Uuid;

class OrderNumber
{
    public function defineOrderNumber(Booking $booking){
        $number= Uuid::uuid4();
        $booking->setOrderNumber($number);
    }
}