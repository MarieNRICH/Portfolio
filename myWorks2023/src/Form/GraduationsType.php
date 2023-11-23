<?php

namespace App\Form;

use App\Entity\Graduations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class GraduationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('schools')
            ->add('studies')
            ->add('img', FileType::class, [
                'label' => 'Photo du diplome',
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
            ]);   
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Graduations::class,
        ]);
    }
}
