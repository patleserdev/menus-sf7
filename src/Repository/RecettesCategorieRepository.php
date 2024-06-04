<?php

namespace App\Repository;

use App\Entity\RecettesCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecettesCategorie>
 *
 * @method RecettesCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecettesCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecettesCategorie[]    findAll()
 * @method RecettesCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecettesCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecettesCategorie::class);
    }

//    /**
//     * @return RecettesCategorie[] Returns an array of RecettesCategorie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecettesCategorie
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
