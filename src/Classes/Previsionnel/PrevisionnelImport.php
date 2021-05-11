<?php
/*
 * Copyright (c) 2021. | David Annebicque | IUT de Troyes  - All Rights Reserved
 * @file /Users/davidannebicque/htdocs/intranetV3/src/Classes/Previsionnel/PrevisionnelImport.php
 * @author davidannebicque
 * @project intranetV3
 * @lastUpdate 05/05/2021 09:10
 */

namespace App\Classes\Previsionnel;

use App\Classes\MyUpload;
use App\Entity\Diplome;
use App\Entity\Matiere;
use App\Entity\Personnel;
use App\Entity\Previsionnel;
use App\Repository\PrevisionnelRepository;
use App\Utils\Tools;
use Doctrine\ORM\EntityManagerInterface;
use function array_key_exists;

/**
 * Class PrevisionnelImport.
 */
class PrevisionnelImport
{
    private PrevisionnelRepository $previsionnelRepository;

    private EntityManagerInterface $entityManager;

    private MyUpload $myUpload;

    public function __construct(
        PrevisionnelRepository $previsionnelRepository,
        EntityManagerInterface $entityManager,
        MyUpload $myUpload
    ) {
        $this->entityManager = $entityManager;
        $this->previsionnelRepository = $previsionnelRepository;
        $this->myUpload = $myUpload;
    }

    /**
     *
     * @throws \Exception
     */
    public function importCsv($data): bool
    {
        $file = $this->myUpload->upload($data['fichier'], 'temp');

        if (null !== $data['diplome']) {
            $matieres = $this->entityManager->getRepository(Matiere::class)->tableauMatieresApogees($data['diplome']); //todo: find plus global... sur toutes les sources possibleS...
            $personnels = $this->entityManager->getRepository(Personnel::class)->tableauPersonnelHarpege($data['diplome']);

            $handle = fopen($file, 'rb');

            /*Si on a réussi à ouvrir le fichier*/
            if ($handle) {
                /* suppression des données de prévi */
                $this->supprPrevisionnel($data['diplome'], $data['annee']);

                /* supprime la première ligne */
                fgetcsv($handle, 1024, ';');
                $annee = $data['annee'];
                /*Tant que l'on est pas à la fin du fichier*/
                while (!feof($handle)) {
                    /*On lit la ligne courante*/
                    $ligne = fgetcsv($handle, 1024, ';');

                    if (array_key_exists($ligne[2], $matieres)) {
                        $personnel = $personnels[$ligne[4]] ?? null;

                        $pr = new Previsionnel($annee, $personnel);
                        $pr->setNbHCm(Tools::convertToFloat($ligne[6]));
                        $pr->setNbGrCm(Tools::convertToInt($ligne[7]));
                        $pr->setNbHTd(Tools::convertToFloat($ligne[8]));
                        $pr->setNbGrTd(Tools::convertToInt($ligne[9]));
                        $pr->setNbHTp(Tools::convertToFloat($ligne[10]));
                        $pr->setNbGrTp(Tools::convertToInt($ligne[11]));
                        $pr->setIdMatiere();
                        $pr->setTypeMatiere();
                        $this->entityManager->persist($pr);
                    }
                }
                $this->entityManager->flush();

                /*On ferme le fichier*/
                fclose($handle);
                unlink($file); //suppression du fichier

                return true;
            }

            return false;
        }

        return false;
    }

    private function supprPrevisionnel(Diplome $diplome, $annee): void
    {
        $pr = $this->previsionnelRepository->findByDiplome($diplome, $annee);
        /** @var Previsionnel $p */
        foreach ($pr as $p) {
            $this->entityManager->remove($p);
        }

        $this->entityManager->flush();
    }
}