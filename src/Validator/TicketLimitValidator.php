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
use Doctrine\ORM\EntityManagerInterface;

class TicketLimitValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function validate($value, Constraint $constraint)
    {
        $maxTicket = $this->em->getRepository('TicketRepository')->getTotalReservations($value);
        if ($maxTicket >= 1000)
        {
            $this->context
                ->buildViolation($constraint->messageMaxTicket)
                ->addViolation();
        }
    }
}