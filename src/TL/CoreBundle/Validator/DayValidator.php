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

    public function validate($value, Constraint $constraint)
    {
        $request = $this->requestStack->getCurrentRequest();
        $choose_date = $request->get('start')['day'];
        $today = \Datetime::createFromFormat('Y/m/d', $choose_date);
        $today_date = $today->format('m/d');

        if($today_date === '05/01' || $today_date === '11/01' || $today_date === '12/25') {
            $this->context->addViolation($constraint->message);
        }     
    }
}
