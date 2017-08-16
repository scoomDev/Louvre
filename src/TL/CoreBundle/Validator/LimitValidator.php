<?php

namespace TL\CoreBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LimitValidator extends ConstraintValidator
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
        $dayEntity = $this->em->getRepository('TLCoreBundle:Day')->findOneByDay($value);
        if(null === $dayEntity) {
            $nbrTickets = 0;
        } else {
            $nbrTickets = $dayEntity->getNbrTickets();
        }
        
        if($nbrTickets >= 10) {
            $this->context->addViolation($constraint->message);
        }
        
    }
}
