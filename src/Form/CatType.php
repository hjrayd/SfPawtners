<?php

namespace App\Form;

use App\Entity\Cat;
use App\Entity\User;
use App\Entity\Breed;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class CatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
                ])
            ->add('gender', ChoiceType::class, [
                    'choices' => [
                        'Femelle' => 'femelle',
                        'Mâle' => 'male',
                    ],
                    'multiple' => false,
                    'label' => 'Sexe'
                    ])
            ->add('dateBirth', DateType::class, [
                    'widget' => 'single_text',
                    'label' => 'Date de naissance',
                        
            ])
            ->add('coat', TextType::class, [
                'label' => 'Robe',
                ])

            ->add('description', TextareaType::class)
            ->add('city', TextType::class, [
                    'label' => 'Ville'
            ])
            ->add('litter', CheckboxType::class, [
                'label' => 'Votre chat a-t-il déjà eu une portée ?',
                'required' => false
            ])
            ->add('breeds', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'breedName',
                'multiple' => true,
                'expanded' => false,
                'label' => 'Race(s)',
            ])
            ->add('images', FileType::class, [
                'label' => 'Vos images (JPG/JPEG/GIF/PNG)',
                'mapped' => false, //ce champ n'existe pas dans notre entité donc unmapped
                'required' => true,
                'multiple' => true,
                'constraints' => [
                    new Count([
                        'max' => 5, // On limite le nombre de fichiers à 5
                        'maxMessage' => 'Vous ne pouvez pas uploader plus de 5 fichiers par chat.',
                    ]),
                    new All([
                        'constraints' => [ //on utilise un tableau donc pour éviter que le formulaire attende une valeur de type "string" on encapsule les contraintes pour qu'elles s'appliquent à chaque fichier
                            new File([
                                'maxSize' => '5M',
                                "maxSizeMessage" => 'Le fichier est trop volumineux',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => 'Veuillez importer une image qui respecte les formats acceptés',
                            ])
                    ]
                    
                    ])
                ]
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cat::class,
            'breeds' => [],
        ]);
    }
}
