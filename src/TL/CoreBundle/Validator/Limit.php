<?php

namespace TL\CoreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Limit extends Constraint
{
    public $message = "La limite de réservation à été atteinte pour ce journée, veuillez choisir un autre jour, merci.";

    public function validatedBy()
    {
        return 'tl_core_limit';
    }
}
