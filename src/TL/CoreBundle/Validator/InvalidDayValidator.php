<?php

namespace TL\CoreBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class InvalidDayValidator extends ConstraintValidator
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

        if ($today->format('d') >= $choose_date->format('d')) {
            $this->context->addViolation($constraint->message);
        }
    }
}
