<?php

namespace App\Repository;

use App\Entity\Merchandise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @method Merchandise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Merchandise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Merchandise[]    findAll()
 * @method Merchandise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 */
class MerchandiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Merchandise::class);
    }

    // /**
    //  * @return Merchandise[] Returns an array of Merchandise objects
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
    public function findOneBySomeField($value): ?Merchandise
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function modifyStock($value,$label) : \Doctrine\ORM\Query
    {
        return $this->createQueryBuilder('m')->update('merchandise','m')->set('m.in_stock','?1')
            ->Where('p.label = ?2')
            ->setParameter(1, $value)->setParameter(2,$label)->getQuery();
    }

}
