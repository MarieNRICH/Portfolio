<?php

namespace App\Repository;

use App\Entity\Graduations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Graduations>
 *
 * @method Graduations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Graduations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Graduations[]    findAll()
 * @method Graduations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GraduationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Graduations::class);
    }

//    /**
//     * @return Graduations[] Returns an array of Graduations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Graduations
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
