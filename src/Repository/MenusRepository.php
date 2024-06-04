<?php

namespace App\Repository;

use App\Entity\Menus;
use App\Entity\Ingredients;
use App\Entity\Recettes;
use App\Entity\IngredientsByRecette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Menus>
 *
 * @method Menus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menus[]    findAll()
 * @method Menus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menus::class);
    }

//    /**
//     * @return Menus[] Returns an array of Menus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Menus
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


            // faire ça : SELECT recettes.id FROM recettes JOIN menus_recettes ON recettes.id = menus_recettes.recettes_id JOIN menus ON menus.id = 1
            //puis la grosse requête
            
        /*
        SELECT ingredients.id, ingredients.title ,recettes.titre,ingredients_by_recette.quantity,mesures.title
        FROM ingredients 
        JOIN recettes ON recettes.id IN (SELECT recettes.id FROM recettes JOIN menus_recettes ON recettes.id = menus_recettes.recettes_id JOIN menus ON menus.id = 1) 
        JOIN ingredients_by_recette ON ingredients_by_recette.ingredient_id = ingredients.id 
        JOIN mesures ON mesures.id = ingredients_by_recette.mesure_id 
        AND ingredients_by_recette.recette_id = recettes.id 
        ORDER BY ingredients.id
        */

        public function getalltheingredientsofthemenu($value)
        {
            /*
           return $this->createQueryBuilder('ingredients')
            ->select('ingredients.id', 'ingredients.title', 'recettes.titre', 'ibr.quantity', 'mesures.title')
            ->join('ingredients.ingredientsByRecette', 'ibr')
            ->join('ibr.recette', 'recettes')
            ->join('ibr.mesure', 'mesures')
            ->join('recettes.menus', 'menuses')
            ->where('menus.id = :menuId')
            ->setParameter('menuId', 1)
            ->orderBy('ingredients.id')
            ->getQuery()
            ->getResult();
            */


            $sql="SELECT ingredients.id, SUM(quantity) as total ,ingredients.title as ingredient,ingredients.categorie_id as categorie ,recettes.titre as recette,ingredients_by_recette.quantity as quantity ,mesures.title as mesure,mesures.id as mesure_id
            FROM ingredients 
            JOIN recettes ON recettes.id IN (SELECT recettes.id FROM recettes JOIN menus_recettes ON recettes.id = menus_recettes.recettes_id JOIN menus ON menus.id = :value) 
            JOIN ingredients_by_recette ON ingredients_by_recette.ingredient_id = ingredients.id 
            JOIN mesures ON mesures.id = ingredients_by_recette.mesure_id 
            AND ingredients_by_recette.recette_id = recettes.id 
            GROUP BY ingredients.id";
            

             $conn = $this->getEntityManager()->getConnection();

             $resultSet = $conn->executeQuery($sql, ['value' => $value]);

            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
           
        }
}
