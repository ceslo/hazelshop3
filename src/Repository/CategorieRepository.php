<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry )
    {
        parent::__construct($registry, Categorie::class);       

    }

    // public function getCategorieMereOnly(){

    //     $entityManager= $this->getEntityManager();

    //     $queryBuilder= $entityManager->createQueryBuilder();
    //     $queryBuilder
    //             ->select('c')
    //             ->from(Categorie::class , 'c')                  
    //             ->Where('c.categorie_mere is NULL');                
    //     $query=$queryBuilder->getQuery();
    //     $categorieMere= $query->getResult();
    //     return $categorieMere;  
      
    // }

    // public function getCategorieByCategorieMere($id){
    
    //     $entityManager=$this->getEntityManager();

    //     $queryBuilder=$entityManager->createQueryBuilder();
    //     $queryBuilder
    //             ->select ('c')
    //             ->from (Categorie::class, 'c')
    //             ->where ('c.categorieMere = :id')
    //             ->setParameter('id', $id); 
    
    //     $query=$queryBuilder->getQuery();
    //     $categorie= $query->getResult();
    //     return $categorie;         
    
    // }

//    /**
//     * @return Categorie[] Returns an array of Categorie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
