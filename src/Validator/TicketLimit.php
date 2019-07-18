<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 17/07/2019
 * Time: 16:21
 */

namespace App\Validator;
use Symfony\Component\Validator\Constraint;

/**
 * Class TicketLimit
 * @package src\Validator
 * @Annotation
 */
class TicketLimit extends Constraint
{
    public $message = "Il n'y a plus de place disponible à cette date !";
}