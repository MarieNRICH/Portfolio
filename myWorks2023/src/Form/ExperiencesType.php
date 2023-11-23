<?php

namespace App\Form;

use App\Entity\Experiences;
use App\Entity\Graduations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ExperiencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('job_title', TextType::class, ['label'=> 'Job title'])
            ->add('companies', TextType::class, ['label'=> 'Company\'s name'])
            ->add('start_date')
            ->add('end_date')
            ->add('activities', TextType::class, ['label'=> 'Activities or Missions'])
            ->add('country')
            ->add('graduation', EntityType::class, [
                'class' => Graduations::class,
                'choice_label' => 'title',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experiences::class,
        ]);
    }
}
