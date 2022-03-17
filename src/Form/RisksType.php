<?php

namespace App\Form;

use App\Entity\Risks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RisksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('identifiedAt')
            ->add('resolvedAt')
            ->add('probability')
            ->add('severity')
            ->add('projects')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Risks::class,
        ]);
    }
}
