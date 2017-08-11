<?php

namespace TL\CoreBundle\Services\Email;

use TL\CoreBundle\Entity\Command;

class TicketsMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, $templating)
    {
    $this->mailer = $mailer;
    $this->templating = $templating;
    }

    public function sendMail(Command $command)
    {
        $message = (new \Swift_Message("Votre réservation de billet"))
            ->setFrom('contact@louvre.fr')
            ->setTo($command->getEmail())
            ->setBody(
                $this->templating->render(
                    "TLCoreBundle:Emails:contactMail.html.twig",
                    [
                        'completeName' => $command->getCompleteName(),
                        'day' => $command->getDay(),
                        'type' => $command->getType(),
                        'tickets' => $command->getTickets()
                    ]
                ),
                'text/html'
            );
        
        $this->mailer->send($message);
    }
}
