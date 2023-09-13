<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Emprunteur;
use App\Entity\Emprunt;
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

        $users = $userRepository->allUsersOrderByMail();

        $user1 = $userRepository->find(1);

        $fooFoo = $userRepository->findByEmail("foo.foo@example.com");
        $roles = $userRepository->roles();

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

        $livres = $livreRepository->findAllLivre();

        $livre1 = $livreRepository->find(1);

        $titreLorem = $livreRepository->findTitreLorem('lorem');

        $listeLivre2 = $livreRepository->findBy([
            'auteur' => 2,
        ], [
            'titre' => 'ASC',
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

        // Mise à jour 

        $genre5 = $genreRepository->find(5);
        $Livre2 = $livreRepository->find(2);

        $Livre2->setTitre('Aperiendum est igitur');
        $Livre2->addGenre($genre5);
        $em->persist($Livre2);
        $em->flush();

        // suppresion id 123

        $id123 = $livreRepository->find(123);

        if ($id123) {
            $em->remove($id123);
            $em->flush();
        }



        // Liste des livres dont la description est genre
        $livreGenre = $livreRepository->findBooksByGenre('roman');

        return $this->render('test/livre.html.twig', [
            'controller_name' => 'TestController',
            'livres' => $livres,
            'livre1' => $livre1,
            'titreLorem' => $titreLorem,
            'listeLivre2' => $listeLivre2,
            'livreGenre' => $livreGenre,

        ]);
    }

    #[Route('/emprunteur', name: 'app_test_emprunteur')]
    public function emprunteur(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $emprunteurRepository = $em->getRepository(Emprunteur::class);
        $userRepository = $em->getRepository(User::class);

        $allEmprunteur = $emprunteurRepository->findEmprunteur();

        $title = 'titre';

        $emprunteur3 = $emprunteurRepository->find(3);

        $user3 = $userRepository->find(3);

        $findFoo = $emprunteurRepository->findFoo('foo');

        $findTel = $emprunteurRepository->findTel('1234');

        $date = new DateTime('2021-03-01');

        $emprunteursBeforeDate = $emprunteurRepository->findEmprunteurByDateCreatedAt($date);
      



        return $this->render('test/emprunteur.html.twig', [
            'controller_name' => 'TestController',
            'title' => $title,
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

        $emprunteurRepository = $em->getRepository(Emprunteur::class);

       

        $title = 'titre 123';

        $value = 10;

        $listeDernierEmprunt = $empruntRepository->listeDerniersEmprunts($value);

        $value2 = $emprunteurRepository->find(2);
        $emprunteur2 = $empruntRepository->findEmprunt2($value2);

        $value3 = $emprunteurRepository->find(3);
        $emprunteur3 = $empruntRepository->findEmprunt3($value3);


        $value1 = 10;
        $retourEmprunt = $empruntRepository->listeDerniersEmpruntsRetour($value1);

        $findIsNull = $empruntRepository->findSpecificIsNulll();

        return $this->render('test/emprunt.html.twig', [
            'controller_name' => 'TestController',
            'title' => $title,
            'listeDernierEmprunt' => $listeDernierEmprunt,
            'emprunteur2' => $emprunteur2,
            'emprunteur3' => $emprunteur3,
            'retourEmprunt' => $retourEmprunt,
            'findIsNull' => $findIsNull,
            
        ]);
    }

    
}
