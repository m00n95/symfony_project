<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/home', name: 'app_home')]
    public function home(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('index/home.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/employee/{id}', name: 'app_employee')]
    public function employee($id, UserRepository $userRepository): Response
    {
        $users = $userRepository->find($id);
        return $this->render('index/employee.html.twig', [
            'user' => $users,
        ]);
    }
}
