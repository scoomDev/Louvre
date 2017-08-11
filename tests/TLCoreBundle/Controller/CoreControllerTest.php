<?php

namespace TL\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use TL\CoreBundle\Entity\Start;
use TL\CoreBundle\Form\StartType;
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
    public function hoursValidator()
    {
        $kernel = $this->getKernel();
        $validator = $kernel->getContainer()->get('tl_core.validator.hours');

        $violationList = $validator->validate('day', new Day);

        $this->assertEquals(1, $violationList->count());
        // or any other like:
        $this->assertEquals('client not valid', $violationList[0]->getMessage());
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
        $client = static::createClient();
        $container = $client->getContainer();
        $em = $container->get('doctrine')->getManager();
        $session = $container->get('session');
        /* dump($client->getContainer()->get('session'));
        die; */

        $start = new Start();
        $start->setDay(new \Datetime())
            ->setCompleteName('Soetaert Christopher')
            ->setnbrPerson(2)
            ->setType('haldDay');

        $session->set('startInfo', $start);
        $startInfo = $session->get('startInfo');
        $crawler = $client->request('GET', '/informations', ['startInfo' => $startInfo]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function summary()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/summary');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
     
}
