<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 17/07/2019
 * Time: 16:23
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TicketLimitValidator extends ConstraintValidator
{
    /**
     * @var TicketRepository
     */
    private $em;
    public function __construct(ReservationRepository $entityManager) {
        $this->em = $entityManager;
    }
    public function validate($visitDay, Constraint $constraint)
    {
        if ($this->em->getTotalReservations($visitDay) >= 1000) {
            $this->context->buildViolation($constraint->message)->atPath('type')->addViolation();
        }
    }
}