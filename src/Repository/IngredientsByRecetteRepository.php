<?php

namespace App\Repository;

use App\Entity\IngredientsByRecette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IngredientsByRecette>
 *
 * @method IngredientsByRecette|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientsByRecette|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientsByRecette[]    findAll()
 * @method IngredientsByRecette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientsByRecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientsByRecette::class);
    }

//    /**
//     * @return IngredientsByRecette[] Returns an array of IngredientsByRecette objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?IngredientsByRecette
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
