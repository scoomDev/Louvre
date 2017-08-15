<?php

namespace TL\CoreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Closed extends Constraint
{
    public $message = "Il est impossible de réservé car nous sommes fermé. Veuillez choisir un autre jour de visite, merci.";

    public function validatedBy()
    {
        return 'tl_core_closed';
    }
}
