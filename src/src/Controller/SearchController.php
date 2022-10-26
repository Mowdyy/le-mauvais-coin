<?php

namespace App\Controller;

use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        $searchBar = $this->createForm(SearchType::class);

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'searchForm' => $searchBar->createView()
        ]);
    }
}
