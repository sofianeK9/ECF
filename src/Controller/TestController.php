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




        return $this->render('test/user.html.twig', [
            'controller_name' => 'TestController',
            'title1' => 'salut ça va',
            'users' => $users,
        ]);
    }
}
