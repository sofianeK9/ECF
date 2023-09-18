<?php

namespace App\Repository;

use App\Entity\Emprunteur;
use DateTime;
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

    /**
     * Cette méthode cherche tous les emprunteurs triés par nom et prénom
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */
    public function findEmprunteur(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->orderBy('e.nom, e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Cette méthode cherche les emprunteurs ou le prénom est égal à foo triés par ordre alphabétique de nom
     * et prénom
     * @param $keyword pour chercher le mot en question
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */
    public function findFoo(string $keyword): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nom LIKE :keyword')
            ->orWhere('e.prenom LIKE :keyword')
            ->setParameter('keyword', "%$keyword%")
            ->orderBy('e.nom, e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Cette méthode cherche les emprunteyrs dont le tel est 1234 triés par nom et prénom
     * @param $keyword pour chercher le mot en question
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */
    public function findTel(string $keyword): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.tel LIKE :keyword')
            ->setParameter('keyword', "%$keyword%")
            ->orderBy('e.nom, e.prenom', 'ASC')

            ->getQuery()
            ->getResult();
    }

    /**
     * Cette méthode cherche les emprunteurs dont la date est antérieur au 01/03/2021
     * @param $keyword pour chercher le mot en question
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */
    public function findEmprunteurByDateCreatedAt(DateTime $date): array
    {


        return $this->createQueryBuilder('e')
            ->select('e')
            ->Where('e.createdAt < :date')
            ->setParameter('date', $date)
            ->orderBy('e.prenom, e.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
