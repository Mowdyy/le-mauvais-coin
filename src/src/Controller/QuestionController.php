<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

<<<<<<< HEAD:src/src/Controller/QuestionController.php
class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_question')]
    public function index(): Response
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
=======
class LogController extends AbstractController
{
    #[Route('/log', name: 'app_log')]
    public function index(): Response
    {
        return $this->render('log/index.html.twig', [
            'controller_name' => 'LogController',
>>>>>>> parent of f10144f (User):src/src/Controller/UserController.php
        ]);
    }
}