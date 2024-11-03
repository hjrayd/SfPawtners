<?php

namespace App\Form;

use App\Entity\Cat;
use App\Entity\User;
use App\Entity\Breed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class CatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Femelle' => 'femelle',
                    'Mâle' => 'male',
                ],

                'multiple' => false,
                'label' => 'Sexe'
            ])
            ->add('dateBirth', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance'
            ])
            ->add('coat', TextType::class, [
                'label' => 'Robe'
            ])
            ->add('description', TextareaType::class)
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('litter', CheckboxType::class, [
                'label' => 'Votre chat a-t-il déjà eu une portée ?',
                'required' => false
            ])
            ->add('breeds', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'breedName',
                'multiple' => true,
                'label' => 'Race(s)'
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cat::class,
        ]);
    }
}
