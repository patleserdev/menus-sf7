<?php

namespace App\Repository;

use App\Entity\IngredientsCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IngredientsCategorie>
 *
 * @method IngredientsCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientsCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientsCategorie[]    findAll()
 * @method IngredientsCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientsCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientsCategorie::class);
    }

//    /**
//     * @return IngredientsCategorie[] Returns an array of IngredientsCategorie objects
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

//    public function findOneBySomeField($value): ?IngredientsCategorie
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
