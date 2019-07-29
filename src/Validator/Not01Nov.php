<?php

namespace App\Validator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Not01Nov extends Constraint
{
    public $message = 'Le musée est fermé le 1er novembre';
}