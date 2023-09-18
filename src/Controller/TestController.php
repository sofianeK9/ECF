<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Emprunteur;
use App\Entity\Emprunt;
use App\Repository\EmpruntRepository;
use DateTime;
use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test')]
class TestController extends AbstractController
{
    #[Route('/user', name: 'app_test_user')]
    public function user(ManagerRegistry $doctrine): Response
    {

        $em = $doctrine->getManager();
        $userRepository = $em->getRepository(User::class);

        // la liste complète de tous les utilisateurs (de la table `user`), triée par ordre alphabétique d'email
        $users = $userRepository->allUsersOrderByMail();

        // les données de l'utilisateur dont l'id est `1`
        $user1 = $userRepository->find(1);

        // les données de l'utilisateur dont l'email est `foo.foo@example.com`
        $fooFoo = $userRepository->findByEmail("foo.foo@example.com");

        // la liste des utilisateurs dont l'attribut `roles` contient le mot clé `ROLE_USER`, triée par ordre alphabétique d'email
        $roles = $userRepository->roles();

        // la liste des utilisateurs inactifs (c-à-d dont l'attribut `enabled` est égal à `false`), triée par ordre alphabétique d'email
        $userFalse = $userRepository->falseEnabled();


        return $this->render('test/user.html.twig', [
            'controller_name' => 'TestController',
            'title1' => 'salut ça va',
            'users' => $users,
            'user1' => $user1,
            'fooFoo' => $fooFoo,
            'roles' => $roles,
            'userFalse' => $userFalse,
        ]);
    }

    #[Route('/livre', name: 'app_test_livre')]
    public function livre(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $livreRepository = $em->getRepository(Livre::class);
        $auteurRepository = $em->getRepository(Auteur::class);
        $genreRepository = $em->getRepository(Genre::class);


        // la liste complète de tous les livres, triée par ordre alphabétique de titre
        $livres = $livreRepository->findAllLivre();

        //  les données du livre dont l'id est `1`
        $livre1 = $livreRepository->find(1);

        // la liste des livres dont le titre contient le mot clé `lorem`, triée par ordre alphabétique de titre
        $titreLorem = $livreRepository->findTitreLorem('lorem');

        // - la liste des livres dont l'id de l'auteur est `2`, triée par ordre alphabétique de titre

        $listeLivre2 = $livreRepository->findBy([
            'auteur' => 2,
        ], [
            'titre' => 'ASC',
        ]);

        // la liste des livres dont le genre contient le mot clé `roman`, triée par ordre alphabétique de titre
        $livreGenre = $livreRepository->findBooksByGenre('roman');

        return $this->render('test/livre.html.twig', [
            'controller_name' => 'TestController',
            'livres' => $livres,
            'livre1' => $livre1,
            'titreLorem' => $titreLorem,
            'listeLivre2' => $listeLivre2,
            'livreGenre' => $livreGenre,

        ]);


        // Création d'un livre
        $auteur2 = $auteurRepository->find(2);
        $genre2 = $genreRepository->find(6);

        $newBooks = new Livre();
        $newBooks->setTitre('Totum autem id externum');
        $newBooks->setAnneeEdition('2020');
        $newBooks->setNombrePages('300');
        $newBooks->setCodeIsbn('9790412882714');
        $newBooks->setAuteur($auteur2);
        $newBooks->addGenre($genre2);
        $em->persist($newBooks);
        $em->flush();

        // Mise à jour  du livre dont l'id est 

        $genre5 = $genreRepository->find(5);
        $Livre2 = $livreRepository->find(2);

        $Livre2->setTitre('Aperiendum est igitur');
        $Livre2->addGenre($genre5);
        $em->persist($Livre2);
        $em->flush();

        // suppresion du livre dont l'id est 123

        $id123 = $livreRepository->find(123);

        if ($id123) {
            $em->remove($id123);
            $em->flush();
        }
    }

    #[Route('/emprunteur', name: 'app_test_emprunteur')]
    public function emprunteur(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $emprunteurRepository = $em->getRepository(Emprunteur::class);
        $userRepository = $em->getRepository(User::class);



        // la liste complète des emprunteurs, triée par ordre alphabétique de nom et prénom
        $allEmprunteur = $emprunteurRepository->findEmprunteur();

        // les données de l'emprunteur dont l'id est `3`
        $emprunteur3 = $emprunteurRepository->find(3);

        //  les données de l'emprunteur qui est relié au user dont l'id est `3`
        $user3 = $userRepository->find(3);

        //  la liste des emprunteurs dont le nom ou le prénom contient le mot clé `foo`, triée par ordre alphabétique de nom et prénom
        $findFoo = $emprunteurRepository->findFoo('foo');

        // la liste des emprunteurs dont le téléphone contient le mot clé `1234`, triée par ordre alphabétique de nom et prénom
        $findTel = $emprunteurRepository->findTel('1234');

        // la liste des emprunteurs dont la date de création est antérieure au 01/03/2021 exclu (c-à-d strictement plus petit), triée par ordre alphabétique de nom et prénom
        $date = new DateTime('2021-03-01');
        $emprunteursBeforeDate = $emprunteurRepository->findEmprunteurByDateCreatedAt($date);

        return $this->render('test/emprunteur.html.twig', [
            'controller_name' => 'TestController',
            'allEmprunteur' => $allEmprunteur,
            'emprunteur3' => $emprunteur3,
            'user3' => $user3,
            'findFoo' => $findFoo,
            'findTel' => $findTel,
            'emprunteursBeforeDate' => $emprunteursBeforeDate,

        ]);
    }


    #[Route('/emprunt', name: 'app_test_emprunt')]
    public function emprunt(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $empruntRepository = $em->getRepository(Emprunt::class);
        $livreRepository = $em->getRepository(Livre::class);
        $emprunteurRepository = $em->getRepository(Emprunteur::class);

        $emprunteurRepository = $em->getRepository(Emprunteur::class);

        $title = 'titre 123';

        // la liste des 10 derniers emprunts au niveau chronologique, triée par ordre **décroissant** de date d'emprunt (le plus récent en premier)
        $value = 10;

        //  la liste des emprunts de l'emprunteur dont l'id est `2`, triée par ordre **croissant** de date d'emprunt (le plus ancien en premier)
        $listeDernierEmprunt = $empruntRepository->listeDerniersEmprunts($value);

        //  la liste des emprunts de l'emprunteur dont l'id est `2`, triée par ordre **croissant** de date d'emprunt (le plus ancien en premier)
        $value2 = $emprunteurRepository->find(2);
        $emprunteur2 = $empruntRepository->findEmprunt2($value2);

        // la liste des emprunts du livre dont l'id est `3`, triée par ordre **décroissant** de date d'emprunt (le plus récent en premier)
        $value3 = $emprunteurRepository->find(3);
        $emprunteur3 = $empruntRepository->findEmprunt3($value3);

        //  la liste des 10 derniers emprunts qui ont été retournés, triée par ordre **décroissant** de date de rendretour (le plus récent en premier)
        $value1 = 10;
        $retourEmprunt = $empruntRepository->listeDerniersEmpruntsRetour($value1);

        //  la liste des emprunts qui n'ont pas encore été retournés (c-à-d dont la date de retour est nulle), triée par ordre **croissant** de date d'emprunt (le plus ancien en premier)
        $findIsNull = $empruntRepository->findSpecificIsNulll();


        // les données de l'emprunt relié au livre dont l'id est `3`
        $livre3 = $empruntRepository->dateEmpruntLivre3(3);


        // création emprunt

        $newEmprunt = new Emprunt();
        $newEmprunt->setDateEmprunt(new DateTime('01/12/2020 16:00:00'));
        $newEmprunt->setDateRetour(null);
        $emprunteurnewid = $emprunteurRepository->find(1);
        $newEmprunt->setEmprunteur($emprunteurnewid);
        $livreid = $livreRepository->find(1);
        $newEmprunt->setLivre($livreid);
        $em->persist($newEmprunt);
        $em->flush();

        // modification emprunt dont l'id est 3

        $empruntId3 = $empruntRepository->find(3);
        $empruntId3->setDateRetour(new DateTime('01/05/2020 10:00:00'));
        $em->flush();

        // suppresion de l'emprunt dont l'id est 42

        $id42 = $empruntRepository->find(42);

        if ($id42) {
            $em->remove($id42);
            $em->flush();
        }

        return $this->render('test/emprunt.html.twig', [
            'controller_name' => 'TestController',
            'title' => $title,
            'listeDernierEmprunt' => $listeDernierEmprunt,
            'emprunteur2' => $emprunteur2,
            'emprunteur3' => $emprunteur3,
            'retourEmprunt' => $retourEmprunt,
            'findIsNull' => $findIsNull,
            'livre3' => $livre3,

        ]);
    }
}
