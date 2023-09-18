<?php

namespace App\Repository;

use App\Entity\Auteur;
use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * Cette méthode retourne la liste compléte de tous les livres triés par ordre alphabétique de titre
     * @return Livre[] Returns an array of Livre objects
     */
    public function findAllLivre(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.titre IS NOT null')
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /**
     * Cette méthode retourne la liste des livres contenants le titre voule entré dans la variable $keyword trié par ordre
     * alphabétique des livres
     * @param  $keyword pour chercher le mot en question
     * @return Livre[] Returns an array of Livre objects
     */
    public function findTitreLorem(string $keyword): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.titre LIKE :keyword')
            ->setParameter('keyword', "%$keyword%")
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Cette méthode retourne la liste des livres contenant le mot clé entré dans la variable $genre triés
     * par ordre alphabétique de titre
     * @param  $keyword pour chercher le mot en question
     * @return Livre[] Returns an array of Livre objects
     */
    public function findBooksByGenre(string $genres): array
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.genres', 'genres')
            ->andWhere('genres.nom LIKE :genres')
            ->setParameter('genres', "%$genres%")
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
