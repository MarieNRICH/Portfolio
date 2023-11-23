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
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SkillsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('soft_skills', TextType::class, ['label' => 'vos savoirs êtres'])
            ->add('hard_skills')
            ->add('expertises')
            ->add('icons', FileType::class, [
                'label' => 'Icon du site',
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
            ->add('duration')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Skills::class,
        ]);
    }
}
