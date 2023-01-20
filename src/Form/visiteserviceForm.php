<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class visiteserviceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entrer',DateType::class, array('label' => 'Date livraison','widget' => 'single_text','required' => false))
            ->add('sortie',DateType::class, array('label' => 'Date livraison','widget' => 'single_text','required' => false))
            ->add('visiteurs', EntityType::class, array('class' => 'App\Entity\Visiteur','placeholder'=>'visiteur','required' => false,
            'empty_data' => ''))
            ->add('services', EntityType::class, array('class' => 'App\Entity\Service','placeholder'=>'service','required' => false,
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
