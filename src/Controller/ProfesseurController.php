<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Form\ProfesseurType;
use App\Repository\ProfesseurRepository;
use App\Service\GenerateCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/professeur')]
final class ProfesseurController extends AbstractController
{
    #[Route(name: 'app_professeur_index', methods: ['GET'])]
    public function index(ProfesseurRepository $professeurRepository): Response
    {
        return $this->render('professeur/index.html.twig', [
            'professeurs' => $professeurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_professeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $professeur = new Professeur();
        $professeur->setMatricule(GenerateCode::matricule());
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($professeur);
            $entityManager->flush();

            return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professeur/new.html.twig', [
            'professeur' => $professeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professeur_show', methods: ['GET'])]
    public function show(Professeur $professeur): Response
    {
        return $this->render('professeur/show.html.twig', [
            'professeur' => $professeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_professeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Professeur $professeur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professeur/edit.html.twig', [
            'professeur' => $professeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professeur_delete', methods: ['POST'])]
    public function delete(Request $request, Professeur $professeur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professeur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($professeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
    }
}
