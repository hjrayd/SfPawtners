<?php

namespace App\Form;

use App\Entity\Coat;
use App\Entity\Breed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('breeds', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'breedName',
                'label' => 'Race(s)',
                'multiple' => true,
                'required' => false,
                'expanded' => true
             
            ])
            ->add('ageMin', NumberType::class, [
                'required' => false,
                 'label' => 'Âge minimum',
        
            ])
            ->add('ageMax', NumberType::class, [
                'required' => false,
                'label' => 'Âge maximum'
            ])
            ->add('coats', EntityType::class, [
                'class' => Coat::class,
                'choice_label' => 'coatName',
                'label' => 'Couleur(s)',
                'multiple' => true,
                'required' => false,
                'expanded' => true
             
            ])
            ->add('city', TextType::class, [
                'required' => false,
                'label'=> 'Ville',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => null
         ]);
    }
}
