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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


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
<<<<<<< Updated upstream

    #[Route('/advert/add', name: 'app_advert_add', methods: ['GET', 'POST'])]
=======
    
    #[Route('/advert', name: 'app_add_advert', methods: ['GET', 'POST'])]
>>>>>>> Stashed changes
    public function addAdvert(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $advert = new Advert();
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = new Product();
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);
            $image = $form->get('image')->getData();
            
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                
                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $advert->setImageFileName($newFilename);
            }
            
            // ... persist the $product variable or any other work
            
            return $this->redirectToRoute('app_home');
            $advert = $form->getData();
            $entityManagerInterface->persist($advert);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_advert');
        }
        return $this->render('advert/addAdvert.html.twig', [
            'form' => $form->createView()
        ]);
    }
<<<<<<< Updated upstream

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
=======
    
    #[Route('/advert/{id}/delete', name: 'app_delete_advert', methods: ['GET', 'POST'])]
>>>>>>> Stashed changes
    public function deleteAdvert($id, AdvertRepository $advertRepository) 
    {
        $advert = $advertRepository->findOneById($id);
        $advertRepository->remove($advert, true);
        return $this->redirectToRoute('app_advert');
    }
}
