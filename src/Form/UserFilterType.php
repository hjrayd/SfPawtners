<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Rechercher',
                'label_attr' => [
                    'class' => 'd-none', 
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher...',
                ]
            ])
            ->add('Valider', SubmitType::class, [
                'label' => 'Rechercher'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        
    }
}
