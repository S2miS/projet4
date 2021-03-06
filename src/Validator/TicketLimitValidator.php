<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 17/07/2019
 * Time: 16:23
 */

namespace App\Validator;

use App\Entity\Booking;
use App\Repository\TicketRepository;
use http\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TicketLimitValidator extends ConstraintValidator
{

    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {

        $this->ticketRepository = $ticketRepository;
    }
    public function validate($value, Constraint $constraint)
    {

        if(!$value instanceof Booking){
            throw new InvalidArgumentException();
        }

        $maxTicket = $this->ticketRepository->getTotalReservations($value->getVisitDay());

        if ($maxTicket + $value->getTicketNumber() > Booking::MAX_TICKET_PER_DAY)
        {
            $this->context
                ->buildViolation($constraint->messageMaxTicket)
                ->atPath('ticketNumber')
                ->addViolation();
        }
    }
}