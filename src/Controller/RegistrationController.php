<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Entity\Stagiaire;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use App\Service\GenerateCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            $userChoice = $form->get('role')->getData();

            if ($userChoice == "professeur") 
            {
                $professeur = new Professeur();
                $user->setRoles(["ROLE_PROFESSEUR"]);
                $professeur->setMatricule(GenerateCode::matricule());
                $professeur->setNom($form->get('nom')->getData());
                $professeur->setPrenom($form->get('prenom')->getData());
                $user->setProfesseur($professeur);
                $entityManager->persist($professeur);
            }
            else
            {
                $stagiaire = new Stagiaire();
                $user->setRoles(["ROLE_STAGIAIRE"]);
                $stagiaire->setNom($form->get('nom')->getData());
                $stagiaire->setPrenom($form->get('prenom')->getData());
                $user->setStagiaire($stagiaire);
                $entityManager->persist($stagiaire);
            }
            

            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();


            return $security->login($user, UserAuthenticator::class, 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
