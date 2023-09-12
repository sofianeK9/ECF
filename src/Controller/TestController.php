<?php

namespace App\Controller;

use App\Entity\User;
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




        return $this->render('test/user.html.twig', [
            'controller_name' => 'TestController',
        
        
        
        ]);

    }
}
