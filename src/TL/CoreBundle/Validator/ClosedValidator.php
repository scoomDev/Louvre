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

    public function validate($value, Constraint $constraint)
    {
        $request = $this->requestStack->getCurrentRequest();
        $choose_date = $request->get('start')['day'];
        $today = new \Datetime();
        $date = \Datetime::createFromFormat('Y/m/d', $choose_date);
        $date_day = $date->format('N');
        $date_hours = $date->format('H');
        $date_minutes = $date->format('i');

        if ($today->format('Y/m/d') == $choose_date) {
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
