<?php

namespace App\Validator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotHoliday extends Constraint
{
    public $message = 'Vous ne pouvez pas commander un jour férié';
}