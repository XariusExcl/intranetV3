<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Classes/Edt/EdtIntranet.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 21/08/2021 16:07
 */

namespace App\Classes\Edt;

use App\DTO\EvenementEdt;
use App\DTO\EvenementEdtCollection;
use App\Entity\Semestre;
use App\Repository\EdtPlanningRepository;

class EdtIntranet extends AbstractEdt implements EdtInterface
{
    private EdtPlanningRepository $edtPlanningRepository;

    public function __construct(EdtPlanningRepository $edtPlanningRepository)
    {
        $this->edtPlanningRepository = $edtPlanningRepository;
    }

    public function getPlanningSemestre(Semestre $semestre, array $matieres = []): EvenementEdtCollection
    {
        $evts = $this->edtPlanningRepository->findAllEdtSemestre($semestre);
        $evtCollection = new EvenementEdtCollection();

        /** @var \App\Entity\EdtPlanning $evt */
        foreach ($evts as $evt) {
            $event = new EvenementEdt();

            if (array_key_exists($evt->getTypeIdMatiere(), $matieres)) {
                $matiere = $matieres[$evt->getTypeIdMatiere()]->display;
            } else {
                $matiere = 'Inconnue';
            }

            $event->date = $evt->getDate();
            $event->jour = $evt->getJour();
            $event->duree = $evt->getDureeInt();
            $event->heure = $evt->getDebutTexte();
            $event->matiere = $matiere;
            $event->typeIdMatiere = $evt->getTypeIdMatiere();
            $event->texte = $evt->getTexte();
            $event->groupeId = $evt->getGroupe();
            $event->personnel = null !== $evt->getIntervenant() ? $evt->getIntervenant()->getDisplayPr() : '-';
            $event->groupe = $evt->getDisplayGroupe();
            $event->type_cours = $evt->getType();
            $event->display = $evt->getTexte() ?? $matiere;
            $evtCollection->add($event);
        }

        return $evtCollection;
    }
}