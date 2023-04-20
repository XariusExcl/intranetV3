<?php

namespace App\Controller\api\unifolio;

use App\Controller\BaseController;
use App\Entity\Groupe;
use App\Repository\EtudiantRepository;
use App\Repository\GroupeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends BaseController
{
    #[Route(path: '/api/unifolio/etudiant', name: 'api_etudiant_liste')]
    public function listeEtudiant(
        Request $request,
        EtudiantRepository $etudiantRepository,
    )
    {
        $this->checkAccessApi($request);

        $etudiants = $etudiantRepository->findAll();

        $tabEtudiant = [];

        foreach ($etudiants as $etudiant) {
            $groupes = [];
            foreach ($etudiant->getGroupes() as $groupe) {
                $groupes[] = [
                    'id' => $groupe->getId(),
                    'libelle' => $groupe->getLibelle(),
                ];
            }

            $tabEtudiant[$etudiant->getId()] = [
                'id' => $etudiant->getId(),
                'nom' => $etudiant->getNom(),
                'prenom' => $etudiant->getPrenom(),
                'mail_univ' => $etudiant->getMailUniv(),
                'mail_perso' => $etudiant->getMailPerso(),
                'telephone' => $etudiant->getTel1(),
                'groupes' => $groupes,
            ];
        }

        return $this->json($tabEtudiant);
    }

}