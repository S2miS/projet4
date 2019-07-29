<?php
namespace App\Validator;
use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class NotTuesday extends Constraint
{
    public $message = 'Le musée est fermé le mardi';
}