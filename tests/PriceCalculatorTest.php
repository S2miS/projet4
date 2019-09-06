<?php

namespace App\Tests\Services;

use App\Entity\Booking;
use App\Entity\Price;
use App\Entity\Ticket;
use App\Repository\PriceRepository;
use App\Service\TicketPrice;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PriceCalculatorTest extends KernelTestCase
{

    /** @var TicketPrice */
    private $ticketPrice;

    public function setUp()
    {
        $kernel = self::bootKernel();

        $priceRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(Price::class);

        $this->ticketPrice = new TicketPrice($priceRepository);
    }


    /**
     * @dataProvider priceCheckProvider
     */
    public function testPriceCheck($discount, $birthday, $type, $expected)
    {

        $ticket = new Ticket();
        $ticket->setDiscount($discount);
        $ticket->setBirthday($birthday);

        $booking = new Booking();
        $booking->setVisitDay(new \DateTime('2000-01-01'));
        $booking->setOrderType($type);
        $booking->addTicket($ticket);


        $this->assertEquals($expected, $this->ticketPrice->priceCheck($ticket));
    }


    public function priceCheckProvider()
    {
        return [
            [false, new \DateTime('1997-01-01'), Booking::TYPE_FULL_DAY, 0], /*Tarif enfant de -4ans*/
            [false, new \DateTime('1994-01-01'), Booking::TYPE_FULL_DAY, 8], /*Tarif enfant*/
            [false, new \DateTime('1994-01-01'), Booking::TYPE_HALF_DAY, 4], /*Tarif enfant mi-journée*/
            [false, new \DateTime('1980-01-01'), Booking::TYPE_FULL_DAY, 16], /*Tarif normal*/
            [false, new \DateTime('1980-01-01'), Booking::TYPE_HALF_DAY, 8], /*Tarif normal mi-journée*/
            [false, new \DateTime('1940-01-01'), Booking::TYPE_FULL_DAY, 12], /*Tarif senior*/
            [false, new \DateTime('1940-01-01'), Booking::TYPE_HALF_DAY, 6], /*Tarif senior mi-journée*/
            [true, new \DateTime('1980-01-01'), Booking::TYPE_FULL_DAY, 10], /*Tarif normal réduit*/
            [true, new \DateTime('1940-01-01'), Booking::TYPE_FULL_DAY, 10], /*Tarif sénior réduit*/
            [true, new \DateTime('1994-01-01'), Booking::TYPE_FULL_DAY, 8], /*Tarif enfant réduit*/
        ];
    }

}