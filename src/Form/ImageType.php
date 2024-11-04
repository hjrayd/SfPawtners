<?php
namespace App\Form;
use App\Entity\Cat;
use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('picture', FileType::class, [
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
            //->add('removePicture', CheckboxType::class, [
                //'label' => 'Supprimer',
                //'required' => false,
            //])
            ->add('cat', EntityType::class, [
                'class' => Cat::class,
                'choice_label' => 'name',
            ])
            ->add('Valider', SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}