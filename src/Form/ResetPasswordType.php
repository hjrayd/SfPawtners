<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe ne correspondent pas',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => false,
            'first_options'  => ['constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/',
                        'message' => 'Le mot de passe doit contenir au minimum une majuscule, une minuscule, un chiffre et 12 caractères dont un caractère spécial',
                    ]),
                ],
                'label' => 'Mot de passe',
            ],
            'second_options' => ['label' => 'Confirmer le mot de passe'],
            'mapped' => false,
       
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}