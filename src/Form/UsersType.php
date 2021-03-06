<?php

namespace App\Form;

use App\Entity\Teams;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('firstName', TextType::class, [
                'required' => true,
                'label' => 'Prénom'
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Adresse mail'
            ])
            ->add('roles', ChoiceType::class, array(
                'attr'  =>  array(
                    'class' => 'form-control'
                ),
                'choices' =>
                    array(
                        'ROLE_USER' => array(
                            'Utilisateur' => 'ROLE_USER',
                        ),
                        'ROLE_ADMIN' => array(
                            'Administrateur' => 'ROLE_ADMIN'
                        )
                    ),
                    'multiple' => true,
                    'required' => true,
                )
            )
            ->add('isTeamManager', CheckboxType::class, [
                'label' => 'Manager de son équipe ?',
                'required' => false,
                'attr' => [
                    'checked' => false
                ]
            ])
            ->add('team', EntityType::class, [
                'class' => Teams::class,
                'choice_label' => 'name',
                'label' => 'Equipe',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
