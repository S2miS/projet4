<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 26/08/2019
 * Time: 18:14
 */

namespace App\Validator;

use App\Entity\Booking;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotAfter14HValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if(!$value instanceof Booking){
            return;
        }

        $date = date('H');
        dump($date);

        /* @var $constraint App\Validator\NotAfter14H */
        if($date >= 14 &&
            $value->getOrderType() === Booking::TYPE_FULL_DAY &&
            $value->getVisitDay()->format('Ymd') === date('Ymd')
        ){
            $this->context->buildViolation($constraint->message)
                ->atPath('orderType')
                ->addViolation();
        }
    }
}