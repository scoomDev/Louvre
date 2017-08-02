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
        ->add('day', DateType::class, [
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'yyyy/MM/dd',
            'attr' => ['class' => 'datepicker']
        ])
        ->add('completeName', TextType::class)
        ->add('email', EmailType::class)
        ->add('nbrPerson', IntegerType::class, [
            'attr' => [
                'min' => 1,
                'max' => 9
            ]
        ])
        ->add('type', ChoiceType::class, [
            'choices' => [
                'Whole day' => 'day',
                'From 2pm' => 'halfDay',
            ]
        ])
        ->add('tickets', CollectionType::class, [
            'entry_type' => TicketType::class,
            'allow_add' => true,
            'allow_delete' => true
        ])
        ->add('send', SubmitType::class, [
            'attr' => ['class' => 'btn btn-success']
        ]);

        // FORM for Informations Path
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {
                $command = $event->getData();
                if(null === $command) {
                    return;
                }
                $request = Request::createFromGlobals();
                $pathInfo = $request->getPathInfo();

                if ($pathInfo === '/informations') {
                    $event->getForm()->add('tickets', CollectionType::class, [
                        'entry_type' => TicketType::class,
                        'allow_add' => true,
                        'allow_delete' => true
                    ])
                    ->add('nbrPerson', HiddenType::class)
                    ->remove('day')
                    ->remove('type');
                } else {
                    $event->getForm()->remove('tickets');
                }
            }
        );
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
