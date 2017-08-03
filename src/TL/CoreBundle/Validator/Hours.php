<?php

namespace TL\CoreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Hours extends Constraint
{
    public $message = "Il est impossible de réserver un ticket pour la journée après 14h00, veuillez choisir une ticket demi-journée.";

    public function validatedBy()
    {
        return 'tl_core_hours';
    }
}
