<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 26/08/2019
 * Time: 18:13
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;


class NotAfter14H extends Constraint
    /**
     * @Annotation
     */
{
    public $message = 'Impossible de prendre une journée complète aujourd\'hui après 14h';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
