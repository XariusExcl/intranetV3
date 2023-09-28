<?php
/*
 * Copyright (c) 2023. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/Sites/intranetV3/src/Classes/EduSign/Adapter/IntranetEdtEduSignAdapter.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 31/08/2023 15:57
 */

namespace App\Classes\EduSign\Adapter;

use App\Classes\EduSign\DTO\EduSignCourse;
use App\DTO\EvenementEdt;
use Carbon\Carbon;

class IntranetEdtEduSignAdapter
{
    private ?EduSignCourse $course;

    /**
     * @param $edt
     */
    public function __construct(EvenementEdt $edt)
    {
        $this->course = new EduSignCourse();
        //complète l'objet $this->>course avec des données fictive pour le test
        $this->course->name = $edt->matiere;
//        $this->course->description = $edt->texte;
        $this->course->description = "hello";

dump("date".$edt->date);
dump("debut".$edt->heureDebut);
dump("fin".$edt->heureFin);
//die();
        // todo: récupérer les bonnes dates :)
        $this->course->start = Carbon::createFromFormat("Y-m-d H:i:s", $edt->heureDebut);
        $this->course->end = Carbon::createFromFormat("Y-m-d  H:i:s", $edt->heureFin);


        $this->course->professor = $edt->personnelObjet->getIdEduSign();
//        $this->course->professor_signature = "http://example.com/signature1.png";
//        $this->course->professor_2 = "PhysicsProfessor2";
//        $this->course->professor_signature_2 = "http://example.com/signature2.png";
        $this->course->classroom = $edt->salle;
//        $this->course->school_group = ["physicsMajors2023", "scienceMajors2023"];
        $this->course->max_students = 30;
//        $this->course->zoom = true;
//        $this->course->api_id = "123456789";
    }

    public function getCourse(): ?EduSignCourse
    {
        return $this->course;
    }
}
