<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('pseudo', TextType::class, [
                'constraints' => [
                    new Length(['min' => 3, 'max'=> 20, 
                    'minMessage'=>'Le pseudo doit contenir 3 caractères minimum.',
                    'maxMessage'=>'Le pseudo doit contenir 20 caractères minimum']),
                ],
                'required'=> true,
            ])
            ->add('image', FileType::class, [
                'label' => 'Ajouter une photo de profil',
                'multiple' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '200K',
                        'maxSizeMessage' => 'L\'image est trop volumineuse', //photo de profil donc plus légère qu'une image de base
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                         
                        ],
                        'mimeTypesMessage' => 'Veuillez importer une image qui respecte les formats acceptés.',
                    ])
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions d\'utilisation pour vous inscrire',
                    ]),
                ],
                'label' => 'J\'accepte les conditions d\'utilisation'
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
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
           
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'register',
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
