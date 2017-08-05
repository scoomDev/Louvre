<?php

namespace TL\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use TL\CoreBundle\Form\TicketType;

class CommandType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // basic FORM
        $builder
        ->add('completeName', TextType::class, [
            'label' => 'Votre nom complet'
        ])
        ->add('email', EmailType::class, [
            'label' => 'Votre adresse email'
        ])
        ->add('nbrPerson', HiddenType::class)
        ->add('tickets', CollectionType::class, [
            'label' => 'Billets',
            'entry_type' => TicketType::class,
            'entry_options' => [
                'label_attr' => [
                    'class' => 'label_tickets_box'
                ],
                'attr' => [
                    'class' => 'tickets_box'
                ]
            ],
            'allow_add' => true,
            'allow_delete' => true
        ])
        ->add('send', SubmitType::class, [
            'label' => 'Valider les informations',
            'attr' => ['class' => 'btn btn-success']
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TL\CoreBundle\Entity\Command'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tl_corebundle_command';
    }


}
