<?php

namespace App\Form;

use App\Entity\Bearings;
use App\Entity\Highlights;
use App\Entity\Projects;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HighlightsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Créé le',
                'required' => true
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('description', TextareaType::class, [
                'required' => true, 
                'label' => 'Description'
            ])
            ->add('bearing', EntityType::class, [
                'class' => Bearings::class,
                'choice_label' => 'name',
                'label' => 'Jalon',
                'required' => false
            ])
            ->add('projects', EntityType::class, [
                'class' => Projects::class,
                'choice_label' => 'name',
                'label' => 'Projet',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Highlights::class,
        ]);
    }
}
