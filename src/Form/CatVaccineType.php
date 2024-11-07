<?php

namespace App\Form;

use App\Entity\Cat;
use App\Entity\CatVaccine;
use App\Entity\Vaccine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatVaccineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateVaccine', null, [
                'widget' => 'single_text',
            ])
            ->add('cat', EntityType::class, [
                'class' => Cat::class,
                'choice_label' => 'name',
            ])
            ->add('vaccine', EntityType::class, [
                'class' => Vaccine::class,
                'choice_label' => 'vaccineName',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CatVaccine::class,
        ]);
    }
}
