<?php

namespace TL\CoreBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DayValidator extends ConstraintValidator
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

        if($choose_date->format('m/d') === '05/01' || $choose_date->format('m/d') === '11/01' || $choose_date->format('m/d') === '12/25') {
            $this->context->addViolation($constraint->message);
        }
    }
}
