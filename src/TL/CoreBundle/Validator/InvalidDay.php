<?php

namespace TL\CoreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class InvalidDay extends Constraint
{
    public $message = "Ce jour est déjà passé, veuillez choisir un autre jour, merci.";

    public function validatedBy()
    {
        return 'tl_core_invalid_day';
    }
}
