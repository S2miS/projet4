<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 16/07/2019
 * Time: 10:06
 */

namespace App\Validator;

use App\Service\TicketPrice;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
class HolidayFranceValidator extends ConstraintValidator
{
    protected $commandeService;
    public function __construct(TicketPrice $ticketPrice)
    {
        $this->commandeService = $ticketPrice;
    }
    public function validate($value, Constraint $constraint){
        if($this->commandeService->verifyIfDateIsClose($value)){
            $this->context->buildViolation($constraint->message)
                ->setParameter("{{ date }}", $value->format("d/m/y"))
                ->addViolation();
        }
    }
}