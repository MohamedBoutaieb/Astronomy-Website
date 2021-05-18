<?php

namespace App\Repository;

use App\Entity\MerchOrdere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MerchOrdere|null find($id, $lockMode = null, $lockVersion = null)
 * @method MerchOrdere|null findOneBy(array $criteria, array $orderBy = null)
 * @method MerchOrdere[]    findAll()
 * @method MerchOrdere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MerchOrdereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MerchOrdere::class);
    }

    // /**
    //  * @return MerchOrdere[] Returns an array of MerchOrdere objects
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
    public function findOneBySomeField($value): ?MerchOrdere
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
