<?php

namespace App\Repository;

use App\Entity\Opac;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Opac|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opac|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opac[]    findAll()
 * @method Opac[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpacRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Opac::class);
    }

    // /**
    //  * @return Opac[] Returns an array of Opac objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Opac
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
