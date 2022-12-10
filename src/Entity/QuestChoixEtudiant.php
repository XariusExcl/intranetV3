<?php

namespace App\Entity;

use App\Components\Questionnaire\Interfaces\QuestChoixInterface;
use App\Entity\Traits\LifeCycleTrait;
use App\Entity\Traits\QuestChoixTrait;
use App\Repository\QuestChoixEtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestChoixEtudiantRepository::class)]
#[ORM\HasLifecycleCallbacks]
class QuestChoixEtudiant extends BaseEntity implements QuestChoixInterface
{
    use QuestChoixTrait;
    use LifeCycleTrait;

    #[ORM\ManyToOne(inversedBy: 'questChoixEtudiants')]
    private ?Etudiant $etudiant = null;

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->etudiant->getMailUniv();
    }

    public function getNom(): string
    {
        return $this->etudiant->getNom();
    }

    public function getPrenom(): string
    {
        return $this->etudiant->getPrenom();
    }

    public function getDisplay(): string
    {
        return $this->etudiant->getDisplayPr();
    }
}
