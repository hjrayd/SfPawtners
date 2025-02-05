<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditPseudoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pseudo', TextType::class, [
            'label'=>'Nouveau pseudo',
            'required' => false,
            'constraints' => [
                new Length(['min' => 3, 'max'=> 20,
            'minMessage' => 'Le pseudo doit comporter 3 caractères minimum',
            'maxMessage' => 'Le pseudo doit comproter 20 caractères maximum']),
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => User::class
        ]);
    }
}
