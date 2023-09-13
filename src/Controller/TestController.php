<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Genre;
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

        if($id123){
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
}
