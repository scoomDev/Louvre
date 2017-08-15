<?php

namespace TL\CoreBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ClosedValidator extends ConstraintValidator
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function validate($choose_date, Constraint $constraint)
    {
        $request = $this->requestStack->getCurrentRequest();
        $today = new \Datetime();
        $date_day = $today->format('N');
        $date_hours = $today->format('H');
        $date_minutes = $today->format('i');

        if ($today->format('Y/m/d') == $choose_date->format('Y/m/d')) {
            if($date_day == 1 || $date_day == 4 || $date_day == 6 || $date_day == 7) {
                if($date_hours >= 18) {
                    $this->context->addViolation($constraint->message2);
                }
            } else if($date_day == 3 || $date_day == 5) {
                if($date_hours >= 21 && $date_minutes >= 45) {
                    $this->context->addViolation($constraint->message2);
                }
            }   
        } else if ($today->format('Y/m') == $choose_date->format('Y/m')){
            if ($today->format('d') > $choose_date->format('d')) {
                $this->context->addViolation($constraint->message3);
            }
        } else if ($choose_date->format('N') == 2 || $choose_date->format('N') == 7) {
            $this->context->addViolation($constraint->message4);
        }
    }
}
