<?php

namespace App\Form;

use App\Entity\RefCivilite;
use App\Entity\RefDepartement;
use App\Entity\RefHobbies;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array('required' => true))
            ->add('firstname', TextType::class, array('required' => true))
            ->add('lastname', TextType::class, array('required' => true))
            ->add('adresse', TextType::class, array('required' => true))
            ->add('codePostal', TextType::class, array('required' => true))
            ->add('ville', TextType::class, array('required' => true))
            ->add('email', EmailType::class, array('required' => true))
            ->add('image', ImageType::class)
            ->add('dateNaissance', DateType::class,
                array(
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy'
                )
            )
            ->add('civilite', EntityType::class, array(
                    'label' => false,
                    'class' => RefCivilite::class,
                    'choice_label' => 'civilite',
                    'empty_data' => 'lg_choisissez',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'attr' => ['class' => 'custom-select']
                )
            )
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $user = $event->getData();

            // si le user n'a rien envoyé
            if (null == $user) {
                return null;
            }

            // si on n'a pas de password et pas d'id user alors on est en création
            if (current($options['validation_groups']) == 'create') {
                $event->getForm()->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les mots de passe doivent correspondre',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                ));
                $event->getForm()->add('save', SubmitType::class, array('label' => 'Sauvegarder'));
            } else {
                $event->getForm()->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les mots de passe doivent correspondre',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => false,
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                ));
                $event->getForm()->add('save', SubmitType::class, array('label' => 'Modifier'));
            }

        }
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
