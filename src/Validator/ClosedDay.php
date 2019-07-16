<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 16/07/2019
 * Time: 10:01
 */

namespace App\Validator;
use Symfony\Component\Validator\Constraint;

/**
 * Class ClosedDay
 * @Annotation
 * @package src\Validator
 */
class ClosedDay extends Constraint
{
    public $message = "Il n'est pas possible de réserver des billets les mardi.";
}