<?php

namespace App\Form;

use App\Entity\Cat;
use App\Entity\Like;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LikeType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        
        $builder
            ->add('catOne', EntityType::class, [
                'class' => Cat::class,
                'choice_label' => 'name',
            ])
            ->add('catTwo', EntityType::class, [
                'class' => Cat::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Like::class,
        ]);
    }
}
