<?php

namespace App\Form;

use App\Entity\Portfolios;
use App\Entity\Projects;
use App\Entity\Status;
use App\Entity\Teams;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('code', HiddenType::class, [
                'empty_data' => 541541
            ])
            ->add('startedAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Débute le',
                'required' => true
            ])
            ->add('endedAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'A terminer pour le',
                'required' => false
            ])
            ->add('isArchived', CheckboxType::class, [
                'label' => 'Archivé ?',
                'required' => false,
                'attr' => [
                    'checked' => false
                ]
            ])
            ->add('initialValue', IntegerType::class, [
                'label' => 'Valeur initiale',
                'required' => true
            ])
            ->add('consumedValue', IntegerType::class, [
                'label' => 'Valeur consommée',
                'required' => true,
                'empty_data' => 0
            ])
            ->add('stillToDo', IntegerType::class, [
                'label' => 'Reste à faire',
                'required' => true
            ])
            ->add('landing', IntegerType::class, [
                'label' => 'Atterrissage',
                'required' => true,
                'empty_data' => 0
            ])
            ->add('teamProject', EntityType::class, [
                'class' => Teams::class,
                'choice_label' => 'name',
                'label' => 'Equipe projet',
                'required' => true
            ])
            ->add('teamCustomers', EntityType::class, [
                'class' => Teams::class,
                'choice_label' => 'name',
                'label' => 'Equipe client',
                'required' => true
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'name',
                'label' => 'Statut',
                'required' => true
            ])
            ->add('portfolio', EntityType::class, [
                'class' => Portfolios::class,
                'choice_label' => 'name',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
