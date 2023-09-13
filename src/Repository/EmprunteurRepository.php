<?php

namespace App\Repository;

use App\Entity\Emprunteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunteur>
 *
 * @method Emprunteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunteur[]    findAll()
 * @method Emprunteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmprunteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunteur::class);
    }

    //    /**
    //     * @return Emprunteur[] Returns an array of Emprunteur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
    public function findEmprunteur(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->orderBy('e.prenom', 'ASC')
            ->orderBy('e.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findFoo(string $keyword): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nom LIKE :keyword')
            ->orWhere('e.prenom LIKE :keyword')
            ->setParameter('keyword', "%$keyword%")
            ->orderBy('e.nom', 'ASC')
            ->orderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findTel(string $keyword): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.tel LIKE :keyword')
            ->setParameter('keyword', "%$keyword%")
            ->orderBy('e.nom', 'ASC')
            ->orderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function BeforeDate(): array
    {
        return $this->createQueryBuilder('e')
            ->Where('e.createdAt < :date')
            ->setParameter('date', new \DateTime('2021-03-01'))
            ->orderBy('e.nom', 'ASC')
            ->orderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }


//    public function findOneBySomeField($value): ?Emprunteur
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
