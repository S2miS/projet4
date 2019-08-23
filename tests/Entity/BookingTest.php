<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 19/08/2019
 * Time: 16:19
 */

namespace App\Tests\Entity;

use App\Entity\Booking;
use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
    public function testOrderType()
    {
        $booking = new Booking();
        $result = $booking->getOrderType();

        $this->assertSame(true, $result);
    }
}