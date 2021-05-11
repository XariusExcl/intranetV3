<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Classes/Matieres/MatiereManager.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 11/05/2021 08:46
 */

namespace App\Classes\Matieres;

use App\Adapter\MatiereMatiereAdapter;
use App\DTO\Matiere;
use App\DTO\MatiereCollection;
use App\Entity\Departement;
use App\Entity\Diplome;
use App\Entity\Semestre;
use App\Repository\MatiereRepository;

class MatiereManager extends AbstractMatiereManager implements MatiereInterface
{
    private MatiereRepository $matiereRepository;

    private MatiereMatiereAdapter $matiereAdapter;

    public function __construct(MatiereRepository $matiereRepository, MatiereMatiereAdapter $matiereAdapter)
    {
        $this->matiereRepository = $matiereRepository;
        $this->matiereAdapter = $matiereAdapter;
    }

    public function find($id): Matiere
    {
        $matiere = $this->matiereRepository->find($id);

        return $this->matiereAdapter->single($matiere);
    }

    public function findBySemestre(Semestre $semestre): MatiereCollection
    {
        $data = $this->matiereRepository->findBySemestre($semestre);

        return $this->matiereAdapter->collection($data);
    }

    public function findByDepartement(Departement $departement): MatiereCollection
    {
        $data = $this->matiereRepository->findByDepartement($departement);

        return $this->matiereAdapter->collection($data);
    }

    public function findByDiplome(Diplome $diplome): MatiereCollection
    {
        $data = $this->matiereRepository->findByDiplome($diplome);

        return $this->matiereAdapter->collection($data);
    }

    public function findByCodeApogee(string $code): ?Matiere
    {
        $matiere = $this->matiereRepository->findBy(['codeElement' => $code]);

        return $this->matiereAdapter->single($matiere);
    }
}
