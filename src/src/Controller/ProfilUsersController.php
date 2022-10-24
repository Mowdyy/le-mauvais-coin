<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilUsersController extends AbstractController
{
    #[Route('/profil/users', name: 'app_profil_users')]
    public function index(): Response
    {
        return $this->render('profil_users/index.html.twig', [
            'controller_name' => 'ProfilUsersController',
        ]);
    }
}
