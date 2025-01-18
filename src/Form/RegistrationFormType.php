<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Professeur' => 'professeur',
                    'Stagiaire' => 'stagiaire',
                ],
                'multiple' => false,
            ])
            ->add('nom', TextType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom de famille.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 20,
                        'minMessage' => 'Votre nom de famille doit comporter au moins 2 caractères.',
                        'maxMessage' => 'Votre nom de famille ne doit pas dépasser 20 caractères.',
                    ]),
                ],
            ])
    
            ->add('prenom', TextType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom.',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 20,
                        'minMessage' => 'Votre prénom doit comporter au moins 2 caractères.',
                        'maxMessage' => 'Votre prénom ne doit pas dépasser 20 caractères.',
                    ]),
                ],
            ])
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins 6 caractères.',
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
