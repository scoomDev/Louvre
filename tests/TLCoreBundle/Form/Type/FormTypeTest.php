<?php

namespace Tests\AppBundle\Form\Type;

use TL\CoreBundle\Form\StartType;
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
        $this->assertTrue($form->isValid());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}