<?php

namespace App\Form;

use App\Entity\RefCivilite;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\File;
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
            ->add('firstname', TextType::class,
                array(
                    'label' => 'Prénom',
                    'required' => true,
                )
            )
            ->add('lastname', TextType::class,
                array(
                    'label' => 'Nom',
                    'required' => true,
                )
            )
            ->add('adresse', TextType::class,
                array(
                    'label' => 'Adresse',
                    'required' => true,
                )
            )
            ->add('codePostal', TextType::class,
                array(
                    'label' => 'Code postal',
                    'required' => true,
                )
            )
            ->add('ville', TextType::class,
                array(
                    'label' => 'Ville',
                    'required' => true,
                )
            )
            ->add('email', EmailType::class,
                array(
                    'label' => 'E-mail',
                    'required' => true,
                )
            )
            ->add('dateNaissance', DateType::class,
                array(
                    'label' => 'Date de naissance',
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'attr' => ['class' => 'datepicker'],
                    'required' => true
                )
            )
            ->add('civilite', EntityType::class, array(
                    'label' => 'Civilité',
                    'class' => RefCivilite::class,
                    'choice_label' => 'civilite',
                    'empty_data' => 'lg_choisissez',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'attr' => ['class' => 'custom-select']
                )
            )->add('captcha', HiddenType::class,
                [
                    'mapped' => false,
                    'required' => true
                ]
            );
        // avant le settage du formulaire
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($options) {
                $user = $event->getData();

                // si le user n'a rien envoyé
                if (null == $user) {
                    return null;
                }

                // si on n'a pas de password et pas d'id user alors on est en création
                if (current($options['validation_groups']) == 'create') {
                    $event->getForm()->add('password', RepeatedType::class,
                        array(
                            'type' => PasswordType::class,
                            'invalid_message' => 'Les mots de passe doivent correspondre',
                            'options' => array('attr' => array('class' => 'password-field')),
                            'required' => true,
                            'first_options' => array('label' => 'Password'),
                            'second_options' => array('label' => 'Repeat Password'),
                        )
                    )->add('avatar', FileType::class, [
                        'label' => 'Avatar',
                        'required' => true,
                        'mapped' => false,
                        // unmapped fields can't define their validation using annotations
                        // in the associated entity, so you can use the PHP constraint classes
                    ])->add('username', TextType::class,
                        array(
                            'label' => 'Identifiant',
                            'required' => true
                        )
                    );
                    $event->getForm()->add('save', SubmitType::class, array('label' => 'Sauvegarder'));
                } else {
                    $event->getForm()->add('password', RepeatedType::class,
                        [
                            'type' => PasswordType::class,
                            'invalid_message' => 'Les mots de passe doivent correspondre',
                            'options' => array('attr' => array('class' => 'password-field')),
                            'required' => false,
                            'first_options' => array('label' => 'Mot de passe'),
                            'second_options' => array('label' => 'Confirmer Mot de passe'),
                        ]
                    )->add('avatar', FileType::class,
                        [
                            'label' => 'Avatar',
                            'required' => false,
                            'mapped' => false,
                        ])->add('username', TextType::class,
                        array(
                            'label' => 'Identifiant',
                            'required' => false,
                            'attr' => ['readonly' => 'readonly']
                        )
                    );
                    $event->getForm()->add('save', SubmitType::class, array('label' => 'Modifier'));
                }

            }
        );
        // avant de submit les données
        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) use ($options) {
                $user = $event->getData();

                // si le user n'a rien envoyé
                if (null == $user) {
                    return null;
                }
                if ($options['validation_groups'] == "create") {
                    if ($userExist = $options['em']->getRepository(User::class)->findOneBy(['email' => $user->getEmail(), 'username' => $user->getUsername()])) {
                        $event->getForm()->get('username')->addError(new FormError("Identifiant ou Email existant."));
                    }
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
            'data_class' => User::class,
            'em' => null
        ]);
    }

    public function getBlockPrefix()
    {
        return 'sm_edit_user';
    }
}
