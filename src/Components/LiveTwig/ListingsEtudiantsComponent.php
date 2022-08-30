<?php
/*
 * Copyright (c) 2022. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/Sites/intranetV3/src/Components/LiveTwig/ListingsEtudiantsComponent.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 30/08/2022 18:01
 */

namespace App\Components\LiveTwig;

use App\Entity\Semestre;
use App\Exception\DiplomeNotFoundException;
use App\Repository\SemestreRepository;
use App\Repository\TypeGroupeRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('listings_etudiants')]
class ListingsEtudiantsComponent
{
    use DefaultActionTrait;

    #[LiveProp]
    public ?Semestre $semestre = null;

    #[LiveProp]
    public ?array $typeGroupes = [];

    public function __construct(
        protected SemestreRepository $semestreRepository,
        protected TypeGroupeRepository $typeGroupeRepository
    ) {
        // $this->findTypeGroupes();
    }

    #[LiveAction]
    public function changeSemestre(
        #[LiveArg] int $semestre)
    {
        $this->semestre = $this->semestreRepository->find($semestre);

        $this->findTypeGroupes();
    }

    private function findTypeGroupes(): void
    {
        $diplome = $this->semestre->getDiplome();

        if (null === $diplome) {
            throw new DiplomeNotFoundException();
        }

        if ($diplome->isApc()) {
            $this->typeGroupes = $this->typeGroupeRepository->findByDiplomeAndOrdreSemestre($diplome,
                $this->semestre->getOrdreLmd());
        } else {
            $this->typeGroupes = $this->typeGroupeRepository->findBySemestre($this->semestre);
        }
    }
}