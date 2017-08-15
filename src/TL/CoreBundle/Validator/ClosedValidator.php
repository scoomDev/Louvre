<?php

namespace TL\CoreBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ClosedValidator extends ConstraintValidator
{
    private $requestStack;
    private $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
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
                    $this->context->addViolation($constraint->message);
                }
            } else if($date_day == 3 || $date_day == 5) {
                if($date_hours >= 21 && $date_minutes >= 45) {
                    $this->context->addViolation($constraint->message);
                }
            } 
        }
    }
}
