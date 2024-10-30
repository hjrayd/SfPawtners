<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('pseudo', TextType::class)
            ->add('avatar', TextType::class, [
                'required' => false 
                ])
           
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['constraints' => [
                        new NotBlank(['message' => 'Le mot de passe ne peut pas être vide.']),
                        new Regex([
                            'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{12,}$/',
                            'message' => 'Le mot de passe doit contenir au minimum une majuscule, une minuscule, un chiffre, 12 caractères dont un caractère spécial',
                        ]),
                    ],
                    'label' => 'Password',
                ],
                'second_options' => [
                    'constraints' => [
                        new NotBlank(['message' => 'Veuillez confirmer votre mot de passe.']),
                    ],
                    'label' => 'Repeat Password'
                ],
                'mapped' => false,
           
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
