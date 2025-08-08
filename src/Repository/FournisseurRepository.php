<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\DetailsCommande;
use App\Entity\Fournisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fournisseur>
 */
class FournisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fournisseur::class);
    }


    public function qteArtSoldByFourni(): array
    {     
        $entityManager = $this->getEntityManager();        

        $queryBuilder= $entityManager->createQueryBuilder();
        $queryBuilder
            ->select('f.nom_fournisseur','a.libelle_article', 'SUM(d.qte_article)') 
            ->from (Fournisseur::class, 'f')
            ->join(Article::class,'a','WITH', 'a.fournisseur= f.id')
            ->join (DetailsCommande::class,'d','WITH','d.article = a.id')
            ->groupBy('f') 
          
            ->orderBy('SUM(d.qte_article)', 'DESC');

            $query=$queryBuilder->getQuery();
        
            $qteByFourni=$query->getResult();
            return $qteByFourni;         
    }

//    /**
//     * @return Fournisseur[] Returns an array of Fournisseur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Fournisseur
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
