<?php

namespace App\Controller;

use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertController extends AbstractController
{
    #[Route('/advert/{id}', name: 'app_advert')]
    public function findAdvertById($id, AdvertRepository $AdvertRepository): Response
    {
        $advert = $AdvertRepository->findOneById($id);
        if (!$advert) {
            throw $this->createNotFoundException("L'annonce que vous recherchez n'existe pas :'(");
        } else {
            return $this->render('advert/index.html.twig', [
                'advert' => $advert,
            ]);
        }
    }

    #[Route('/advert')]
    public function redirectToHome()
    {
        return $this->redirectToRoute('app_home');
    }
}
