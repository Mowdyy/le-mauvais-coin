<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HeaderController extends AbstractController
{
    public function searchForm(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'HeaderController',
        ]);
    }
}