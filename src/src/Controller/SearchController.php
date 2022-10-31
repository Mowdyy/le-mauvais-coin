<?php

namespace App\Controller;

use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AdvertRepository;



use App\Form\SearchAdvertType;


class SearchController extends AbstractController
{
    public function index(Request $request,AdvertRepository $advertRepository): Response
    {
        $searchBar = $this->createForm(SearchAdvertType::class, null,[
            'action' => $this->generateUrl('app_handleSearch'),
        ]);
        return $this->render('search/index.html.twig', [
            'searchForm' => $searchBar->createView()
        ]);
        
    }

    #[Route('/handleSearch', name: 'app_handleSearch', methods: ['GET','POST'])]
    public function handleSearch(Request $request, AdvertRepository $advertRepository) {
        //dd($request->request->all('search_advert'));
        $query = $request->request->all('search_advert')['keyword'];
        if($query){
            $adverts = $advertRepository->getFilteredAdverts($query);
        }else{
            $adverts = $advertRepository->findAll();
        }
        return $this->render('home/index.html.twig', [
            'adverts' => $adverts,
            // 'filteredAdverts' => $advert
        ]);
    }

}
