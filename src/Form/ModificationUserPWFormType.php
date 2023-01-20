<?php /** @noinspection ALL */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ModificationUserPWFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomUser')
            ->add('prenomUser')
            ->add('nomUtilisateur')
            ->add('services')
     
            ->add('telUser')
            ->add('roles',  ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices'  => [
                    'Admin' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                    'Superviseur' => 'ROLE_SUP',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
