<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('messageContent', TextareaType::class,[
                'label' => 'Votre message'
            ]);
            
            //Si un destinataire est passé en option comme dans notre méthode show
            if (isset($options['receiver'])) {
                $builder
                        //Le champ est pré rempli avec le pseudo du destinataire
                    ->add('receiver', EntityType::class, [
                        'class' => User::class,
                        'choice_label' => 'pseudo',
                        'data' => ($options['receiver']),

                        //On masque le champ et le label
                        "attr" => [
                            "class" => "d-none"
                        ],
                        "label_attr" => [
                            "class" => "d-none"
                        ]
                    ]);
            }
                $builder
                ->add('Envoyer', SubmitType::class);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'receiver' => null // si aucun destinataire n'est passé en option il prend la valeur null
        ]);
    }
}
