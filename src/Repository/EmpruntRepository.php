<?php

namespace App\Repository;

use App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunt>
 *
 * @method Emprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunt[]    findAll()
 * @method Emprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

    /**
     * Cette méthode affiche la liste des 10 derniers emprunts triés par ordre décroissant de date d'emprunt
     * @param $value la valeur à entrer
     * @return Emprunt[] Returns an array of Emprunt objects
     */
    public function listeDerniersEmprunts($value): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.dateEmprunt', 'DESC')
            ->setMaxResults($value)
            ->getQuery()
            ->getResult();
    }

    /**
     * Cette méthode affiche les emprunts d'un emprunteur triés par ordre croissant de date d'emprunt
     * @param $value2 la valeur à entrer
     * @return Emprunt[] Returns an array of Emprunt objects
     */
    public function findEmprunt2($value2): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.emprunteur = :value')
            ->setParameter('value', $value2)
            ->orderBy('e.dateEmprunt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Cette méthode affiche les emprunts d'un emprunteur triés par ordre decroissant de date d'emprunt
     * @param $value3 la valeur à entrer
     * @return Emprunt[] Returns an array of Emprunt objects
     */
    public function findEmprunt3($value3): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.livre = :value')
            ->setParameter('value', $value3)
            ->orderBy('e.dateEmprunt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /** 
     * Cette méthode cherche la liste des 10 derniers emprunts triés par ordre décroissant de date de retour
     * @param $value1 la valeur à entrer
     * @return Emprunt[] Returns an array of Emprunt objects
     */
    public function listeDerniersEmpruntsRetour($value1): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.dateRetour IS NOT NULL')
            ->orderBy('e.dateRetour', 'DESC')
            ->setMaxResults($value1)
            ->getQuery()
            ->getResult();
    }

    /** 
     * Cette méthode cherche la liste des emprunts qui n'ont pas encore été retournés triés par ordre croissant de date d'emprunt
     * @return Emprunt[] Returns an array of Emprunt objects
     */
    public function findSpecificIsNulll(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.dateRetour IS NULL')
            ->orderBy('e.dateRetour', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /** 
     * Cette méthode cherche les données d'un emprunt relié à un livre
     * @param $value la valeur à entrer
     * @return Emprunt[] Returns an array of Emprunt objects
     */
    public function dateEmpruntLivre3($value): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.livre = :value')
            ->setParameter('value', $value)
            ->getQuery()
            ->getResult();
    }
}
