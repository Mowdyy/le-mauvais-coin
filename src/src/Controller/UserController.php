<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_User')]
    public function index(): Response
    {
        return $this->render('User/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/{id}/vote/{direction}', name: 'app_User')]
    public function userVote($id, $direction)
    {
        if ($direction === 'up') {
            $voteCount = rand(7, 50);
        } else {
            $voteCount = rand(0, 5);
        }

        return new JsonResponse([
            'votes' => $voteCount
        ]);
    }
}
