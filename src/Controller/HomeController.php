<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Entity\User;
use App\Repository\MatiereRepository;
use App\Repository\StageRepository;
use App\Repository\StagiaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('stagiaire/compte', name: 'app_compte_stagiaire', methods: ['GET'])]
    public function compte_stagiaire(StageRepository $stageRepository, MatiereRepository $matiereRepository): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $stagiaire = $user->getStagiaire();

        $stages = $stagiaire->getStages();

        $matieres = [];
        foreach ($stages as $stage) {
            foreach ($stage->getMatiere() as $matiere) {
                if (!in_array($matiere, $matieres)) {
                    $matieres[] = $matiere;
                }
            }
        }

        return $this->render('home/compte_stagiaire.html.twig', [
            'stagiaire' => $stagiaire,
            'stages' => $stages,
            'matieres' => $matieres,
        ]);
    }

    #[Route('professeur/compte', name: 'app_compte_professeur', methods: ['GET'])]
    public function compte_professeur(): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $professeur = $user->getProfesseur();

        $matieres = $professeur ? $professeur->getMatiere() : [];

        return $this->render('home/compte_professeur.html.twig', [
            'matieres' => $matieres,
        ]);
    }

    #[Route('stagiaire/insciption_stagiaire',name: 'app_stage_dispo_index', methods: ['GET'])]
    public function index_inscription_stagiaire(StageRepository $stageRepository): Response
    {
        return $this->render('home/stage_dispo.html.twig', [
            'stages' => $stageRepository->findAll(),
        ]);
    }

    #[Route('/stagiaire/insciption_stagiaire/inscription/{id}', name: 'app_stage_register', methods: ['GET', 'POST'])]
    public function registerStage(Stage $stage, EntityManagerInterface $entityManager): Response 
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();


        $stagiaire = $user->getStagiaire();

        if ($stagiaire->getStages()->contains($stage)) {
            $this->addFlash('error', 'Vous êtes déjà inscrit à ce stage.');
            return $this->redirectToRoute('app_stage_dispo_index');
        }

        $stagiaire->addStage($stage);

        $entityManager->flush();

        $this->addFlash('success', 'Inscription au stage réussie.');
        return $this->redirectToRoute('app_stage_dispo_index');
    }

}
