<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Form\AdvertType;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertController extends AbstractController
{
    #[Route('/advert', name: 'app_advert')]
    public function index(AdvertRepository $advertRepository)
    {
        $adverts = $advertRepository->findAll();
        return $this->render('home/index.html.twig', [
            'adverts' => $adverts,
        ]);
    }

    #[Route('/advert/add', name: 'app_advert_add', methods: ['GET', 'POST'])]
    public function addAdvert(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $advert = new Advert();
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $advert = $form->getData();
            $entityManagerInterface->persist($advert);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_advert');
        }
        return $this->render('advert/addAdvert.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/advert/{id}', name: 'app_advert_page')]
    public function findAdvertById($id, AdvertRepository $advertRepository): Response
    {
        $advert = $advertRepository->findOneById($id);
        if (!$advert) {
            throw $this->createNotFoundException("L'annonce que vous recherchez n'existe pas :'(");
        } else {
            return $this->render('advert/index.html.twig', [
                'advert' => $advert,
            ]);
        }
    }

    #[Route('/advert/{id}/delete', name: 'app_advert_delete', methods: ['GET', 'POST'])]
    public function deleteAdvert($id, AdvertRepository $advertRepository) 
    {
        $advert = $advertRepository->findOneById($id);
        $advertRepository->remove($advert, true);
        return $this->redirectToRoute('app_advert');
    }
}
