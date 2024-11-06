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
            
            if (isset($options['receiver'])) {
                $builder
                    ->add('receiver', EntityType::class, [
                        'class' => User::class,
                        'choice_label' => 'pseudo',
                        'data' => ($options['receiver']),
                        'attr'=> [
                            'style' => 'display:none'
                        ]
                    ]);
            }   else {

                $builder
                    ->add('receiver', EntityType::class, [
                        'class' => User::class,
                        'choice_label' => 'pseudo'
                    ]);
                }

                $builder
                ->add('Envoyer', SubmitType::class);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'receiver' => null
        ]);
    }
}
