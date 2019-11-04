<?php

namespace App\Form;

use App\Entity\Events;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre :',
            ])
            ->add('startDate', DateTimeType::class, [
                'label' => 'Début :',
                'format' => 'dd/MM/yyyy HH:mm',
                'widget' => 'single_text',
                'attr' => array(
                    'placeholder' => 'jj/mm/aaaa hh:mm',
                    'class' => 'datetimepicker',
                ),
                'invalid_message' => 'Heure incorrecte.'
            ])
            ->add('endDate', DateTimeType::class,
                [
                    'label' => 'Fin :',
                    'format' => 'dd/MM/yyyy HH:mm',
                    'widget' => 'single_text',
                    'attr' => array(
                        'placeholder' => 'jj/mm/aaaa hh:mm',
                        'class' => 'datetimepicker',
                    ),
                    'invalid_message' => 'Heure incorrecte.'
                ]
            )->add('nbParticipants', TextType::class,
                [
                    'label' => 'Nombre de participants :',
                    'required' => true
                ]
            )->add( 'place', TextType::class,
                [
                    'label' => 'Lieu :',
                    'required' => true
                ]
            )->add( 'eventsPlace', HiddenType::class,
                [
                    'required' => false,
                    'label' => false,
                    'mapped' => false
                ]
            );

        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'checkDate']);
    }

    /**
     * Vérifie si la date de début est ok par rappor à la date de fin ou du jour
     * @param FormEvent $event
     * @throws \Exception
     */
    public function checkDate(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        $start = $data->getStartDate();
        $end = $data->getEndDate();
        $now = new \DateTime('now');
        if ($start->getTimestamp() >= $end->getTimestamp()) {
            $event->getForm()->get('startDate')->addError(
                new FormError("La date de début doit être inférieur à la date de fin.")
            );
        }
        if ($now->getTimestamp() >= $start->getTimestamp()) {
            $event->getForm()->get('startDate')->addError(
                new FormError("La date de début doit être supérieur à la date du jour.")
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return "sm_event";
    }
}
