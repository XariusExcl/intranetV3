<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Classes\EduSign\ApiEduSign;
use App\Classes\EduSign\CreateEnseignant;
use App\Classes\EduSign\FixCourses;
use App\Classes\EduSign\UpdateEdt;
use App\Classes\EduSign\UpdateEtudiant;
use App\Classes\EduSign\UpdateGroupe;
use App\Entity\Constantes;
use App\Entity\Departement;
use App\Repository\DepartementRepository;
use App\Repository\DiplomeRepository;
use App\Repository\PersonnelDepartementRepository;
use App\Repository\PersonnelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function PHPUnit\Framework\throwException;

#[Route('/administration/edusign')]
class EduSignController extends BaseController
{
    public function __construct(
        protected DiplomeRepository              $diplomeRepository,
        protected DepartementRepository          $departementRepository,
        protected PersonnelDepartementRepository $personnelDepartementRepository,
        protected PersonnelRepository            $personnelRepository,
        protected CreateEnseignant               $createEnseignant,
    )
    {

    }

    #[Route('/', name: 'app_edu_sign')]
    public function index(Request $request): Response
    {
        $diplomes = $this->diplomeRepository->findAllWithEduSign();
        $departements = [];
        foreach ($diplomes as $diplome) {
            $departements[$diplome->getDepartement()->getId()] = $this->departementRepository->find($diplome->getDepartement()->getId());
        }

        if ($request->query->get('dept')) {
            $departement = $this->departementRepository->findOneBy(['id' => $request->query->get('dept')]);
        } else {
            $departement = $departements[array_key_first($departements)];
        }

        $personnelsDepartement = $this->personnelDepartementRepository->findBy(['departement' => $departement]);

        // Filter personnelsDepartement
        $filteredPersonnelsDepartement = array_filter($personnelsDepartement, function ($p) use ($departement) {
            $idEduSignArray = $p->getPersonnel()->getIdEduSign() ?? [];
            return empty($idEduSignArray) || !array_key_exists($departement->getId(), $idEduSignArray);
        });

        return $this->render('/administration/edu_sign/index.html.twig', [
            'departements' => $departements,
            'departementSelect' => $departement ?? null,
            'personnelsDepartement' => $filteredPersonnelsDepartement,
        ]);
    }

    #[Route('/init/{id}', name: 'app_edu_sign_init')]
    public function init(?int $id, UpdateGroupe $updateGroupe, UpdateEtudiant $updateEtudiant)
    {
        if ($id !== 0) {
            $departement = $this->departementRepository->find($id);
            $diplomes = $this->diplomeRepository->findByDepartement($departement);
            $keyEduSign = null;
            foreach ($diplomes as $diplome) {
                if ($diplome->getKeyEduSign() !== null) {
                    $keyEduSign = $diplome->getKeyEduSign();
                }
            }
            $updateGroupe->update($keyEduSign);
            $updateEtudiant->update($keyEduSign);

            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'Les données ont été mises à jour sur EduSign');
        }

        return $this->redirectToRoute('app_edu_sign');
    }

    #[Route('/update/etudiants/{id}', name: 'app_edu_sign_update_etudiants')]
    public function updateEtudiants(?int $id, UpdateGroupe $updateGroupe, UpdateEtudiant $updateEtudiant)
    {
        if ($id !== 0) {
            $departement = $this->departementRepository->find($id);
            $diplomes = $this->diplomeRepository->findByDepartement($departement);
            $keyEduSign = null;
            foreach ($diplomes as $diplome) {
                if ($diplome->getKeyEduSign() !== null) {
                    $keyEduSign = $diplome->getKeyEduSign();
                }
            }

            $updateEtudiant->changeSemestre($keyEduSign);

            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'Les données ont été mises à jour sur EduSign');
        }

        return $this->redirectToRoute('app_edu_sign');
    }

    #[Route('/create-courses/{opt}/{id}', name: 'app_edu_sign_create_courses')]
    public function createCourses(?int $opt, ?int $id, UpdateEdt $updateEdt, FixCourses $fixCourses): Response
    {
        if ($id !== null) {
            $departement = $this->departementRepository->find($id);
            $diplomes = $this->diplomeRepository->findByDepartement($departement);
            $keyEduSign = null;
            foreach ($diplomes as $diplome) {
                if ($diplome->getKeyEduSign() !== null) {
                    $keyEduSign = $diplome->getKeyEduSign();
                }
            }
            //créer les cours pour la semaine
            $updateEdt->update($keyEduSign, $opt);

            $fixCourses->fixCourse($keyEduSign);
        }

        return $this->redirectToRoute('app_edu_sign');
    }

    #[Route('/create-personnel/{deptId}', name: 'app_edu_sign_create_personnel')]
    public function createPersonnel(?int $deptId, Request $request)
    {
        if ($deptId !== 0) {
            $departement = $this->departementRepository->find($deptId);
            $diplomes = $this->diplomeRepository->findByDepartement($departement);
            $keyEduSign = null;
            foreach ($diplomes as $diplome) {
                if ($diplome->getKeyEduSign() !== null) {
                    $keyEduSign = $diplome->getKeyEduSign();
                }
            }

            $personnelId = $request->get('personnel');

            $personnel = $this->personnelRepository->find($personnelId);

            $this->createEnseignant->update($personnel, $departement, $keyEduSign);

            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'Les données ont été mises à jour sur EduSign');
        }

        return $this->redirectToRoute('app_edu_sign');
    }
}