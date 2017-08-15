<?php

namespace Tests\AppBundle\Form\Type;

use TL\CoreBundle\Form\StartType;
use TL\CoreBundle\Form\TicketType;
use Symfony\Component\Form\Test\TypeTestCase;

class TestedTypeTest extends TypeTestCase
{
    /** @test */
    public function startForm()
    {
        $today = new \Datetime('2017/11/01');
        $formData = [
            'day' => $today->format('Y/m/d'),
            'completeName' => 'Soetaert Christopher',
            'email' => 'soetaert.chris@gmail.com',
            'nbrPerson' => 2,
            'type' => 'halfDay'
        ];

        $form = $this->factory->create(StartType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    /** @test */
    public function ticketForm()
    {
        $formData = [
            'lastName' => 'Soetaert',
            'firstName' => 'Christopher',
            'country' => 'FR',
            'birthday' => new \Datetime('1985/05/24'),
            'isReduced' => 'true'
        ];

        $form = $this->factory->create(TicketType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}