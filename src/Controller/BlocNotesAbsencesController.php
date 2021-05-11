<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Controller/BlocNotesAbsencesController.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 11/05/2021 08:46
 */

namespace App\Controller;

use App\Classes\Etudiant\EtudiantAbsences;
use App\Classes\Etudiant\EtudiantNotes;
use App\Classes\Matieres\TypeMatiereManager;
use App\Classes\Previsionnel\PrevisionnelManager;
use App\Classes\StatsAbsences;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlocNotesAbsencesController.
 */
class BlocNotesAbsencesController extends BaseController
{
    public function personnel(PrevisionnelManager $myPrevisionnel): Response
    {
        $previsionnels = $myPrevisionnel->getPrevisionnelPersonnelDepartementAnnee($this->getConnectedUser(),
            $this->dataUserSession->getDepartement(),
            $this->dataUserSession->getAnneePrevisionnel());

        return $this->render('bloc_notes_absences/personnel.html.twig', [
            'previsionnel' => $previsionnels,
        ]);
    }

    /**
     * @throws Exception
     */
    public function etudiantAbsences(
        TypeMatiereManager $typeMatiereManager,
        EtudiantAbsences $etudiantAbsences,
        StatsAbsences $statsAbsences
    ): Response {
        $etudiantAbsences->setEtudiant($this->getConnectedUser());
        $matieres = $typeMatiereManager->findBySemestreArray($this->getEtudiantSemestre());
        $absences = $etudiantAbsences->getAbsencesParSemestresEtAnneeUniversitaire($matieres,
            $this->getEtudiantAnneeUniversitaire());
        $statistiquesAbsences = $statsAbsences->calculStatistiquesAbsencesEtudiant($absences);

        return $this->render('bloc_notes_absences/etudiant_absences.html.twig', [
            'absences' => $absences,
            'etudiant' => $this->getConnectedUser(),
            'statistiquesAbsences' => $statistiquesAbsences,
            'matieres' => $matieres,
        ]);
    }

    public function etudiantNotes(TypeMatiereManager $typeMatiereManager, EtudiantNotes $etudiantNotes): Response
    {
        $matieres = $typeMatiereManager->findBySemestreArray($this->getEtudiantSemestre());
        $etudiantNotes->setEtudiant($this->getConnectedUser());
        $notes = $etudiantNotes->getNotesParSemestresEtAnneeUniversitaire($matieres,
            $this->getEtudiantAnneeUniversitaire());

        return $this->render('bloc_notes_absences/etudiant_notes.html.twig', [
            'notes' => $notes,
            'matieres' => $matieres,
        ]);
    }

    public function mccSemestre(TypeMatiereManager $typeMatiereManager): Response
    {
        return $this->render('bloc_notes_absences/mcc.html.twig', [
            'matieres' => $typeMatiereManager->findBySemestre($this->getEtudiantSemestre()),
        ]);
    }
}
