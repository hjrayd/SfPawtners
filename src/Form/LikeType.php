<?php

namespace App\Form;

use App\Entity\Cat;
use App\Entity\Like;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LikeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $cats = $options['cats'];

        $builder
            ->add('catOne', EntityType::class, [
                'class' => Cat::class,
                'choice_label' => 'id',
                'data' => ($options['catOne']),
                        "attr" => [
                            "class" => "d-none"
                        ],
                        "label_attr" => [
                            "class" => "d-none"
                        ]
            ])
            ->add('catTwo', EntityType::class, [
                'class' => Cat::class,
                'choices' => $cats,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Like::class,
            'cats' => [],  
            'catOne' => null,
        ]);
    }
}
