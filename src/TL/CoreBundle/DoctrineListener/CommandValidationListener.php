<?php

namespace TL\CoreBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use TL\CoreBundle\Services\Email\TicketsMailer;
use TL\CoreBundle\Entity\Command;

class CommandValidationListener
{
  /**
   * @var TicketsMailer
   */
  private $ticketsMailer;

  public function __construct(TicketsMailer $ticketsMailer)
  {
    $this->ticketsMailer = $ticketsMailer;
  }

  public function postPersist(LifecycleEventArgs $args)
  {
    $entity = $args->getObject();

    if (!$entity instanceof Command) {
      return;
    }

    $this->ticketsMailer->sendMail($entity);
  }
}
