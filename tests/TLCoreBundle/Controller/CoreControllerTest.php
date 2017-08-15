<?php

namespace TL\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use TL\CoreBundle\Entity\Start;
use TL\CoreBundle\Entity\Ticket;
use TL\CoreBundle\Entity\Command;
use TL\CoreBundle\Validator\Day;

class CoreControllerTest extends WebTestCase
{
    private function getKernel()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        return $kernel;
    }

    /**
     * @test
     */
    public function index()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Billetterie', $client->getResponse()->getContent());
    }

    /**
     * @test
     */
    public function informations()
    {
        $kernel = $this->getKernel();
        $client = static::createClient();
        $container = $client->getContainer();
        $session = $container->get('session');
        $validator = $container->get('validator');
        $em = $container->get('doctrine')->getManager();

        $start = new Start();
        $start->setDay(new \Datetime('2017-08-16'))
            ->setCompleteName('Soetaert Christopher')
            ->setEmail('soetaert.chris@gmail.com')
            ->setnbrPerson(2)
            ->setType('haldDay');

        $session->set('startInfo', $start);
        
        $errors = $validator->validate($start);
        
        $crawler = $client->request('GET', '/informations');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(0, count($errors));
    }

    /**
     * @test
     */
    public function summary()
    {
        $kernel = $this->getKernel();
        $client = static::createClient();
        $container = $client->getContainer();
        $session = $container->get('session');
        $validator = $container->get('validator');
        $calculator = $container->get('tl_core.services.calculator');
        $today = new \Datetime();

        $ticket1 = new Ticket();
        $ticket1->setLastName('Soetaert')
            ->setFirstName('Christopher')
            ->setCountry('FR')
            ->setBirthday(new \Datetime('1985-05-24'))
            ->setIsReduced(true);

        $ticket2 = new Ticket();
        $ticket2->setLastName('Mourlas')
            ->setFirstName('Camille')
            ->setCountry('FR')
            ->setBirthday(new \Datetime('1987-08-29'))
            ->setIsReduced(false);

        $command = new Command();
        $command->setDay(new \Datetime())
            ->setCompleteName('Soetaert Christopher')
            ->setEmail('soetaert.chris@gmail.com')
            ->setnbrPerson(2)
            ->setType('halfDay');
        $command->addTicket($ticket1);
        $command->addTicket($ticket2);

        $totalPrice = [];
        foreach ($command->getTickets() as $ticket) {
            $age = $calculator->age($today, $ticket->getBirthday());
            $price = $calculator->price($age, $command->getType(), $ticket->getIsReduced());
            $totalPrice[] = $price;
        }

        $session->set('command', $command);        
        $errors = $validator->validate($command);
        $crawler = $client->request('GET', '/summary');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(0, count($errors));
        $this->assertEquals(13, array_sum($totalPrice));
    }
}
