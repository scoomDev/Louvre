<?php

namespace TL\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StartType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('day', DateType::class, [
            'label' => 'Jour de la visite',
            'widget' => 'single_text',
            'placeholder' => 'cliquez ici !',
            'html5' => false,
            'format' => 'yyyy/MM/dd',
            'attr' => ['class' => 'datepicker']
        ])
        ->add('completeName', TextType::class, ['label' => 'Votre nom complet'])
        ->add('email', EmailType::class, ['label' => 'Votre adresse email'])
        ->add('nbrPerson', IntegerType::class, [
            'label' => 'Pour combien de personnes',
            'attr' => [
                'min' => 1,
                'max' => 9
            ]
        ])
        ->add('type', ChoiceType::class, [
            'choices' => [
                'Journée' => 'day',
                'Demi-journée' => 'halfDay',
            ]
        ])
        ->add('send', SubmitType::class, [
            'label' => 'Je réserve !',
            'attr' => ['class' => 'btn btn-success']
        ]);
    }
}
