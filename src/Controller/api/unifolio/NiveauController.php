<?php

namespace App\Controller\api\unifolio;

use App\Controller\BaseController;
use App\Repository\ApcNiveauRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NiveauController extends BaseController
{
    #[Route(path: '/api/unifolio/niveau', name: 'api_niveau_liste')]
    public function listeNiveau(
        Request $request,
        ApcNiveauRepository $niveauRepository
    )
    {
        $this->checkAccessApi($request);

        $niveaux = $niveauRepository->findAll();

        $tabApcNiveau = [];

        foreach ($niveaux as $niveau) {
            $tabApcNiveau[$niveau->getId()] = [
                'id' => $niveau->getId(),
                'libelle' => $niveau->getLibelle(),
                'ordre' => $niveau->getOrdre(),
                'competences' => $niveau->getCompetence()->getLibelle(),
            ];
        }
        return $this->json($tabApcNiveau);
    }
}