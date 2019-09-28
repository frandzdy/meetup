<?php

namespace App\Form;

use App\Entity\Events;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre :',
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Date de début :',
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'invalid_message' => 'Date incorrecte.',
                'html5' => false,
                'attr' => [
                    'autocomplete' => 'Off',
                    'class' => 'datepicker',
                ]
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Date de fin :',
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'invalid_message' => 'Date incorrecte.',
                'html5' => false,
                'attr' => [
                    'autocomplete' => 'Off',
                    'class' => 'datepicker',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }
}
