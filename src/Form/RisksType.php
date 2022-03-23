<?php

namespace App\Form;

use App\Entity\Projects;
use App\Entity\Risks;
use App\Entity\Severities;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RisksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true, 
                'label' => 'Nom'
            ])
            ->add('identifiedAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Identifié le',
                'required' => true
            ])
            ->add('resolvedAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Résolu le',
                'required' => false
            ])
            ->add('probability', TextType::class, [
                'required' => true,
                'label' => 'Probabilité'
            ])
            ->add('severity', EntityType::class, [
                'class' => Severities::class,
                'choice_label' => 'name',
                'label' => 'Sévérité',
                'required' => true
            ])
            ->add('projects', EntityType::class, [
                'class' => Projects::class,
                'choice_label' => 'name',
                'label' => 'Projet',
                'required' => true  
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Risks::class,
        ]);
    }
}
