<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EditAvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'task_item',
        ]);
    }
}
