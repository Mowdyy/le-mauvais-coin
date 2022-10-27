<?php

namespace App\Controller;

use App\Repository\UserRegisterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRegisterRepository $userRegisterRepository)
    {
        $users = $userRegisterRepository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }
}
