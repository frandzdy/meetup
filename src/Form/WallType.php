<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Wall;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WallType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Qu\'avez-vous en tête aujourd\'hui ?',
                'class' => 'form-control input-lg p-text-area mentions'
            ],
            'required' => true
        ])
            ->add('video', VideoType::class)
            ->add('photo', ImageType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'csrf_protection' => true,
            'csrf_token_id' => 'add-wall'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'sm_wall';
    }
}
