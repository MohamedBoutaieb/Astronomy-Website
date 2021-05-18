<?php

namespace App\Repository;

use App\Entity\MerchOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MerchOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method MerchOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method MerchOrder[]    findAll()
 * @method MerchOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MerchOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MerchOrder::class);
    }

    // /**
    //  * @return MerchOrder[] Returns an array of MerchOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MerchOrder
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
