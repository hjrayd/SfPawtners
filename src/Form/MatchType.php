<?php

namespace App\Form;

use App\Entity\Cat;
use App\Entity\Matches;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateMatch', null, [
                'widget' => 'single_text',
            ])
            ->add('statutMatch')
            ->add('catOne', EntityType::class, [
                'class' => Cat::class,
                'choice_label' => 'id',
            ])
            ->add('catTwo', EntityType::class, [
                'class' => Cat::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matches::class,
        ]);
    }
}
