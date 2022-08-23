<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('typeVisite', ChoiceType::class,[
            'choices'=>[
                'Professionnel'=>'1',
                'Personnel'=>'2',
            ]
            ])
            ->add('motif', TextareaType::class)
            ->add('visiteurs', EntityType::class, array('class' => 'App\Entity\Visiteur','placeholder'=>'visiteur'))
            ->add('services', EntityType::class, array('class' => 'App\Entity\Service','placeholder'=>'service'))
            ->add('users', EntityType::class, array('class' => 'App\Entity\User','placeholder'=>'Personnels'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
