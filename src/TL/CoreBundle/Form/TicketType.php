<?php

namespace TL\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('lastName', TextType::class, [
            'label' => 'Votre nom'
        ])
        ->add('firstName', TextType::class, [
            'label' => 'Votre prénom'
        ])
        ->add('country', CountryType::class, [
            'label' => 'Pays',
            'placeholder' => "Choississez votre pays"
        ])
        ->add('birthday', DateType::class, [
            'label' => 'Votre date de naissance',
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'yyyy/MM/dd',
            'attr' => ['class' => 'birthday']
        ])
        ->add('isReduced', CheckboxType::class, [
            'label' => 'Prix réduit',
            'required' => false
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TL\CoreBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tl_corebundle_ticket';
    }


}
