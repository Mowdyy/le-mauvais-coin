<?php

namespace App\Controller;

use App\Entity\Advert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AdvertRepository;

class AdvertController extends AbstractController
{
    #[Route('/advert/list', name: 'app_advert_list')]
    public function getAdvertsList(AdvertRepository $advertRepository): Response
    {
        return $this->render('advert_list/index.html.twig', [
            "adverts" => $advertRepository->joinDemo()
        ]);
    }

    #[Route('/advert/{id}', name: 'app_advert_by_id')]
    public function getAdvertById(Advert $advert)
    {
        if ($advert->getId()) {
            return $this->render('advert/index.html.twig');
        }
        dd($advert);
    }
}
