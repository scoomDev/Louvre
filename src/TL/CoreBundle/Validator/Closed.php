<?php

namespace TL\CoreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Closed extends Constraint
{
    public $message1 = "Il est impossible de réservé pour aujourd'hui. Veuillez choisir un autre jour de visite, merci.";
    public $message2 = "Il est impossible de réservé car nous sommes fermé. Veuillez choisir un autre jour de visite, merci.";
    public $message3 = "Ce jour est déjà passé, veuillez choisir un autre jour, merci.";
    public $message4 = "Il est impossible de réservé pour ce jour. Veuillez choisir un autre jour de visite, merci.";

    public function validatedBy()
    {
        return 'tl_core_closed';
    }
}
