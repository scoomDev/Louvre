<?php

namespace TL\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use TL\CoreBundle\Entity\Command;
use TL\CoreBundle\Entity\Ticket;
use TL\CoreBundle\Entity\Start;

use TL\CoreBundle\Form\CommandType;
use TL\CoreBundle\Form\TicketType;
use TL\CoreBundle\Form\StartType;

class CoreController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $this->get('session');
        $start = new Start();
        $form = $this->get('form.factory')->create(StartType::class, $start);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $session->set('startInfo', $start);
            return $this->redirectToRoute('tl_core_informations');
        }

        return $this->render('TLCoreBundle:Core:index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function informationsAction(Request $request)
    {
        $starInfo = $this->get('session')->get('startInfo');
        $ticket = new Ticket();
        $command = new Command();
        $command->setDay($starInfo->getDay());
        $command->setCompleteName($starInfo->getCompleteName());
        $command->setEmail($starInfo->getEmail());
        $command->setNbrPerson($starInfo->getNbrPerson());
        $command->setType($starInfo->getType());
        
        $form = $this->get('form.factory')->create(CommandType::class, $command);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            dump($command);
            die('command');
        }

        return $this->render('TLCoreBundle:Core:informations.html.twig', [
            'form' => $form->createView(),
            'startInfos' => $starInfo
        ]);
    }
}
