<?php

namespace App\Repository;

use App\Entity\Etudiant;
use App\Entity\QuestChoixEtudiant;
use App\Entity\QuestQuestionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestChoixEtudiant>
 *
 * @method QuestChoixEtudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestChoixEtudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestChoixEtudiant[]    findAll()
 * @method QuestChoixEtudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestChoixEtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestChoixEtudiant::class);
    }

    public function save(QuestChoixEtudiant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(QuestChoixEtudiant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByQuestionnaire(QuestQuestionnaire $questionnaire): array
    {
        return $this->createQueryBuilder('q')
            ->innerJoin(Etudiant::class, 'e', 'WITH', 'q.etudiant = e.id')
            ->where('q.questionnaire = :questionnaire')
            ->setParameter('questionnaire', $questionnaire)
            ->orderBy('e.nom', 'ASC')
            ->addOrderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function compteReponse(QuestQuestionnaire $questionnaire)
    {
        $qb = $this->createQueryBuilder('prov');

        return $this->createQueryBuilder('q')
            ->select($qb->expr()->countDistinct('q.etudiant'))
            ->innerJoin(QuestQuestionnaire::class, 'qq', 'WITH', 'q.questionnaire = qq.id')
            ->where('qq.id = :questionnaire')
            ->setParameter('questionnaire', $questionnaire->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }
}
