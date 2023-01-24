<?php

namespace App\Form;

use App\Entity\Rdv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class RdvProfessionnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('daterdv',DateTimeType::class, array('label' => 'Date du rendez-vous','widget' => 'single_text','required' => false))
            ->add('motifrdv')
            ->add('services',EntityType::class, array('class' => 'App\Entity\Service','placeholder'=>'service'))
            ->add('visiteurs',EntityType::class, array('class' => 'App\Entity\Visiteur','placeholder'=>'visiteur'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
        ]);
    }
}
