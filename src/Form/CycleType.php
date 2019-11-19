<?php

namespace App\Form;

use App\Entity\Cycle;
use App\Entity\Formateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CycleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NumAction')
            ->add('CreditImpot')
            ->add('DroitTirage')
            ->add('Article39')
            ->add('theme')
            ->add('Mode')
            ->add('lieu')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('Horaire')
            ->add('Formateur', EntityType::class, [
                'class' => Formateur::class,
                'choice_label' => 'Cin',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cycle::class,
        ]);
    }
}
