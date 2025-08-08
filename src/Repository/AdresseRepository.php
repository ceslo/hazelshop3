<?php

namespace App\Repository;

use App\Entity\Adresse;
use App\Entity\Client;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adresse>
 */
class AdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adresse::class);
    }

    //    /**
    //     * @return Adresse[] Returns an array of Adresse objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function  findAdressesExistantes($utilisateur): array
    {
        return $this->createQueryBuilder('a')
            ->join(Utilisateur::class, 'u')
            ->join(Client::class, 'c')
            ->where('u.client=c.id')
            ->where('c.id = a.client')
            ->andWhere('u.id= :uti')
            ->setParameter('uti', $utilisateur)
            ->getQuery()
            ->getResult()
        ;
    }
}
