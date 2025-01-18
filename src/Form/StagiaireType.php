<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Stagiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 20,
                        'minMessage' => 'Le nom doit comporter au moins 2 caractères.',
                        'maxMessage' => 'Le nom ne doit pas dépasser 20 caractères.',
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 20,
                        'minMessage' => 'Le prénom doit comporter au moins 2 caractères.',
                        'maxMessage' => 'Le prénom ne doit pas dépasser 20 caractères.',
                    ])
                ]
            ])
            ->add('adresse')
            ->add('code')
            ->add('ville')
            ->add('dateInscription', null, [
                'widget' => 'single_text',
            ])
           /* ->add('stages', EntityType::class, [
                'class' => Stage::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'required' => false,
            ])*/ 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
