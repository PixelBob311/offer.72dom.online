<?php

namespace App\Repository;

use App\Entity\OfferEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OfferEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferEntity[]    findAll()
 * @method OfferEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferEntity::class);
    }

    // /**
    //  * @return OfferEntity[] Returns an array of OfferEntity objects
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
    public function findOneBySomeField($value): ?OfferEntity
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
