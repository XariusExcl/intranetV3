<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Adapter/PrevisionnelRessourceAdapter.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 02/05/2021 18:44
 */

namespace App\Adapter;


use App\Classes\Previsionnel\PrevisionnelRessourceManager;
use App\DTO\Previsionnel;
use App\DTO\PrevisionnelCollection;

class PrevisionnelRessourceAdapter implements PrevisionnelAdapterInterface
{

    public function collection(array $previsionnels): PrevisionnelCollection
    {
        $collection = new PrevisionnelCollection();
        /** @var \App\Entity\Previsionnel $previ */
        foreach ($previsionnels as $previ) {
            $collection->add($this->single($previ));
        }

        return $collection;
    }

    public function single($previ): Previsionnel
    {
        $p = new Previsionnel();
        $p->id = $previ['id_previsionnel'];
        $p->annee = $previ['annee'];
        $p->referent = $previ['referent'];
        $p->type_matiere = PrevisionnelRessourceManager::TYPE;
        $p->nbHCm = $previ['nbHCm'];
        $p->nbHTd = $previ['nbHTd'];
        $p->nbHTp = $previ['nbHTp'];
        $p->nbGrCm = $previ['nbGrCm'];
        $p->nbGrTd = $previ['nbGrTd'];
        $p->nbGrTp = $previ['nbGrTp'];
        $p->matiere_id = $previ['id_ressource'];
        $p->matiere_libelle = $previ['libelle'];
        $p->matiere_code = $previ['codeRessource'];
        $p->matiere_code_element = '---';
        $p->personnel_id = $previ['id_personnel'];
        $p->personnel_nom = $previ['nom'];
        $p->personnel_prenom = $previ['prenom'];
        $p->personnel_numeroHarpege = $previ['numeroHarpege'];
        $p->personnel_mail = $previ['mailUniv'];
        $p->nbHeuresService = $previ['nbHeuresService'];
        $p->semestre_id = $previ['id_semestre'];
        $p->semestre_libelle = $previ['libelle_semestre'];
        $p->annee_id = $previ['id_annee'];
        $p->annee_libelle = $previ['libelle_annee'];
        $p->diplome_id = $previ['id_diplome'];
        $p->diplome_libelle = $previ['libelle_diplome'];

        return $p;
    }
}