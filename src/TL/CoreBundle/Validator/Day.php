<?php

namespace TL\CoreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Day extends Constraint
{
    public $message = "Ce jour est férié et nous sommes fermé, veuillez choisir un autre jour, merci.";

    public function validatedBy()
    {
        return 'tl_core_day';
    }
}
