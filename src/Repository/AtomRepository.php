<?php

namespace App\Repository;

use App\Entity\Atom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Atom>
 *
 * @method Atom|null find($id, $lockMode = null, $lockVersion = null)
 * @method Atom|null findOneBy(array $criteria, array $orderBy = null)
 * @method Atom[]    findAll()
 * @method Atom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Atom::class);
    }

//    /**
//     * @return Atom[] Returns an array of Atom objects
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

//    public function findOneBySomeField($value): ?Atom
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
