<?php

namespace App\Form;

use App\Entity\Sites;
use App\Entity\Skills;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tech')
            ->add('content')
            ->add('link')
            ->add('title')
            ->add('img', FileType::class, [
                'label' => 'Photo du site',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                    'maxSize' => '5000k',
                    'mimeTypes' => [
                    'image/*',
                    ],
                    'mimeTypesMessage' => 'Image trop lourde',
                    ])
                ],
            ])               
            ->add('skill', EntityType::class, [
                'class' => Skills::class,
                'choice_label' => 'soft_skills',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sites::class,
        ]);
    }
}
