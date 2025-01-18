<?php

namespace App\Controller;

use App\Repository\MatiereRepository;
use App\Repository\StagiaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RapportVisualisationController extends AbstractController
{
    #[Route('admin/rapport-visualisation/stage-inscritpion', name: 'app_rapport_visualisation_stage_inscription',  methods: ['GET'])]
    public function rapportStageInscription(StagiaireRepository $stagiaireRepository): Response
    {
        $stagiaires = $stagiaireRepository->findAll();
        return $this->render('rapport_visualisation/rapportStageInscription.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    #[Route('admin/rapport-visualisation/stage-professeur', name: 'app_rapport_visualisation_stage_professeur',  methods: ['GET'])]
    public function rapportStageProfesseur(MatiereRepository $matiereRepository): Response
    {
        $matieres = $matiereRepository->findAll();
        $professeurs = [];
    
        foreach ($matieres as $matiere) {
            $professeur = $matiere->getProfesseur();
            if ($professeur) {
                $professeurs[$professeur->getId()]['professeur'] = $professeur;
                $professeurs[$professeur->getId()]['matieres'][] = $matiere;
            }
        }
    
        return $this->render('rapport_visualisation/rapportStageProfesseur.html.twig', [
            'professeurs' => $professeurs,
        ]);
    }
    
}
