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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class CatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('gender', TextType::class)
            ->add('dateBirth', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('coat', TextType::class)
            ->add('description', TextareaType::class)
            ->add('city', TextType::class)
            ->add('litter', ChoiceType::class)
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'pseudo',
            ])
            ->add('breeds', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'breedName',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cat::class,
        ]);
    }
}
