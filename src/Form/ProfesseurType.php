<?php

namespace App\Form;

use App\Entity\Professeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class ProfesseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', NumberType::class, [
                    'constraints' => [
                        new Range([
                            'min' => 100,
                            'max' => 1000,
                            'notInRangeMessage' => 'Le matricule doit être compris entre 100 et 1000.',
                        ]),
                    ],
                ])
            ->add('nom')
            ->add('prenom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}
