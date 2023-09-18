<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * Cette méthode cherche tous les users triés par ordre alphabétique d'email
     * @return User[] Returns an array of User objects
     */
    public function allUsersOrderByMail(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email IS NOT null')
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /**
     * Cette méthode cherche un user avec un mail spécifique
     * @param string $email est utilisé pour chercher l'email
     * @return User[] Returns an array of User objects
     */
    public function findByEmail(string $email): array
    {
        return $this->createQueryBuilder('u')
            ->setParameter('email', "%$email%")
            ->andWhere('u.email LIKE :email')
            ->getQuery()
            ->getResult();
    }

    /**
     * Cette méthode cherche tous les users ayant le role ROLE_USER triés par ordre alphabétique d'email
     * @return User[] Returns an array of User objects
     */
    public function roles(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :roles')
            ->setParameter('roles', '%ROLE_USER%')
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Cette méthode cherche les utilisateurs inactifs dont l'attribut enabled est égal à false
     * @return User[] Returns an array of User objects
     */
    public function falseEnabled(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.enabled = :false')
            ->setParameter('false', false)
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
