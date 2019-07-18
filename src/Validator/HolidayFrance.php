<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 16/07/2019
 * Time: 10:05
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class HolidayFrance
 * @package src\Validator
 * @Annotation
 */
class HolidayFrance extends Constraint
{
    public $message = 'Il n\'est pas possible de réserver pour cette date. Le {{ date }} est un jour férié en France. ';
}