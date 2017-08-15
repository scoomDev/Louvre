<?php

namespace TL\CoreBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HoursValidator extends ConstraintValidator
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

        $today = new \Datetime();
        $choose_date = $this->context->getObject()->getDay();
    
        if($today->format('Y/m/d') === $choose_date->format('Y/m/d')) {
            if($today->format('H') >= "14") {
                if($value === 'day') {
                    $this->context->addViolation($constraint->message);
                }
            }
        }                
    }
}
