<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => 
                    new NotBlank([
                        'message' => 'Le nom du chat est requis.',
                    ]),
              'attr' => [
                    'placeholder' => 'Rechercher...',
                   
                ],
                'label' => 'Rechercher',
                'label_attr' => [
                    'class' => 'd-none', 
                ],
                
                'required' => false
            ])
            ->add('Valider', SubmitType::class, [
                'label' => 'Rechercher'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
