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
    /**
     * Homepage
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        /**
         * BREADCRUMBS White October Bundle
         */
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Choisissez votre date", $this->get("router")->generate("tl_core_homepage"));

        $session = $this->get('session');
        $start = new Start(); // Starting information store in the Start object
        $form = $this->get('form.factory')->create(StartType::class, $start);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $session->set('startInfo', $start);
            return $this->redirectToRoute('tl_core_informations');
        }

            return $this->render('TLCoreBundle:Core:index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Informations page
     *
     * @param Request $request
     * @return Response
     */
    public function informationsAction(Request $request)
    {
        /**
         * BREADCRUMBS White October Bundle
         */
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs
            ->addItem("Choisissez votre date", $this->get("router")->generate("tl_core_homepage"))
            ->addItem("Informations", $this->get("router"));

        /**
         * Service Calculator - TLCoreBundle\Services\Calculator
         */
        $calculator = $this->container->get('tl_core.services.calculator');
        $starInfo = $this->get('session')->get('startInfo');
        
        $ticket = new Ticket();
        /**
         * Hydrate Command
         */
        $command = new Command();
        $command->setDay($starInfo->getDay());
        $command->setCompleteName($starInfo->getCompleteName());
        $command->setEmail($starInfo->getEmail());
        $command->setNbrPerson($starInfo->getNbrPerson());
        $command->setType($starInfo->getType());
        
        $form = $this->get('form.factory')->create(CommandType::class, $command);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            /**
             * Calculate the price of the tickets together with the total price
             */
            $totalPriceArray = [];
            for ($i=1; $i <= count($form->getData()->getTickets()); $i++) {
                $actualTicket = $form->getData()->getTickets()['ticket'.$i];
                $birthday = $actualTicket->getBirthday();
                $age = $calculator->age($starInfo->getDay(), $birthday);
                if($actualTicket->getIsReduced() === true) {
                    $price = 10;
                } else {
                    $price = $calculator->price($age);
                }
                $totalPriceArray[] = $price;

                if($command->getType() === 'halfDay') {
                    $actualTicket->setPrice($price/2);
                } else {
                    $actualTicket->setPrice($price);
                }
            }

            /**
             * Checks the type of tickets
             */
            if($command->getType() === 'halfDay') {
                $totalPrice = array_sum($totalPriceArray)/2;
            } else {
                $totalPrice = array_sum($totalPriceArray);
            }

            $command->setTotalPrice($totalPrice);

            foreach ($command->getTickets() as $ticket) {
                $ticket->setCommand($command);
            }

            $session = $this->get('session');
            $session->set('command', $command);

            return $this->redirectToRoute('tl_core_summary');
        }

        return $this->render('TLCoreBundle:Core:informations.html.twig', [
            'form' => $form->createView(),
            'startInfos' => $starInfo
        ]);
    }

    /**
     * Summary page
     *
     * @param Request $request
     * @return Response
     */
    public function summaryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * BREADCRUMBS White October Bundle
         */
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs
            ->addItem("Choisissez votre date", $this->get("router")->generate("tl_core_homepage"))
            ->addItem("Informations", $this->get("router")->generate("tl_core_informations"))
            ->addItem("Récapitulatif", $this->get("router"));

        $command = $this->get('session')->get('command');
        
        /**
         * Stripe payment module
         */
        if ($request->isMethod('POST')) {
            \Stripe\Stripe::setApiKey("sk_test_aT8SM4fWwtBpAvQ5AsWZRpEb");

            $token = $_POST['stripeToken'];

            try {
                $charge = \Stripe\Charge::create(array(
                    "amount" => $command->getTotalPrice()*100,
                    "currency" => "eur",
                    "source" => $token,
                    "description" => "Paiement Stripe - billetterie Le Louvre"
                ));

                $em->persist($command);
                $em->flush();

                $this->addFlash("success","Votre paiement a bien été accepté, vous allez recevoir vos billets par email. Le Louvre vous remercie !");
                return $this->redirectToRoute("tl_core_homepage");
            } catch(\Stripe\Error\Card $e) {

                $this->addFlash("error","Il semblerait qu'il y ai eu un soucis, réessayez et si cela ne fonctionne toujours, veuillez contacter nos services, merci.");
                return $this->redirectToRoute("tl_core_summary");
            }
        }

        return $this->render('TLCoreBundle:Core:summary.html.twig', [
            'command' => $command
        ]);
    }
}
