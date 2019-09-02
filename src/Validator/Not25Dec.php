<?php

namespace App\Validator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Not25Dec extends Constraint
{
    public $message = 'Le musée est fermé pour Noel.';
}