<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('breeds', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'breedName',
                'multiple' => true,
                'required' => false,
                'placeholder' => 'Race(s)'
            ])
            ->add('ageMin', NumberType::class, [
                'required' => false,
                'placeholder' => 'Âge minimum',
            ])
            ->add('ageMax', NumberType::class, [
                'required' => false,
                'placeholder' => 'Âge maximum',
            ])
            ->add('color', ChoiceType::class, [
                'choices' => $options['colors'],
                'multiple' => true,
                'required' => false,
                'placeholder' => 'Couleur(s)',
            ])
            ->add('city', TextType::class, [
                'required' => false,
                'placeholder' => 'Ville',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'colors' => [],
        ]);
       
    }
}
