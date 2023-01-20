<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class VisiteFiltrageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('entrer',DateTimeType::class, array('label' => 'Date livraison','widget' => 'single_text','required' => false))
        ->add('sortie',DateTimeType::class, array('label' => 'Date livraison','widget' => 'single_text','required' => false))
            ->add('crerpar', EntityType::class, array('class' => 'App\Entity\User','placeholder'=>'employer','required' => false,
            'empty_data' => ''))
            ->add('fermerpar', EntityType::class, array('class' => 'App\Entity\User','placeholder'=>'employer','required' => false,
            'empty_data' => ''))
            ->add('users')
            ->add('visiteurs', EntityType::class, array('class' => 'App\Entity\Visiteur','placeholder'=>'visiteur','required' => false,
            'empty_data' => ''))
            ->add('services', EntityType::class, array('class' => 'App\Entity\Service','placeholder'=>'service','required' => false,
            'empty_data' => ''))
            ->add('users', EntityType::class, array('class' => 'App\Entity\User','placeholder'=>'employer','required' => false,
            'empty_data' => ''))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
