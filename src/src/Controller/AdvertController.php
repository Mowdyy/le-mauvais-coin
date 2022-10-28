<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Question;
use App\Form\AdvertType;
use App\Form\QuestionType;
use App\Form\SearchAdvertType;
use App\Repository\AdvertRepository;
use App\Repository\QuestionRepository;
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
    public function index(AdvertRepository $advertRepository,Request $request)
    {
        $form = $this->createForm(SearchAdvertType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $adverts = $advertRepository->getFilteredAdverts($form->getData()['keyword']);
        }else{
            $adverts = $advertRepository->findAll();
        }
        return $this->render('home/index.html.twig', [
            'adverts' => $adverts,
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/advert/add', name: 'app_advert_add', methods: ['GET', 'POST'])]
    public function addAdvert(Request $request, AdvertRepository $advertRepository, EntityManagerInterface $entityManagerInterface, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        if($user){
            $advert = new Advert();
            $form = $this->createForm(AdvertType::class, $advert);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
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
                
                $advert = $form->getData();
                $advert->setUserRegister($user);
                $advertRepository->save($advert, true);
    
                return $this->redirectToRoute('app_advert');
            }
        }else{
            return $this->redirectToRoute('app_advert');
        }
        
        return $this->render('advert/addAdvert.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/advert/{id}', name: 'app_advert_page')]
    public function findAdvertById(EntityManagerInterface $entityManagerInterface,Request $request,$id, AdvertRepository $advertRepository): Response
    {
        $question = new Question();
        $advert = $advertRepository->findOneById($id);
        $questions = $advert->getQuestions();
        $questionForm = $this->createForm(QuestionType::class, $question);
        $questionForm->handleRequest($request);
        if($questionForm->isSubmitted() && $questionForm->isValid()){
            //dd($questionForm->getData());
            return $this->redirectToRoute('app_question_add', [
                'id' => $id, 
                'questionFormData' => $questionForm->getData()->getTitle()
            ]);
        }
        if (!$advert) {
            throw $this->createNotFoundException("L'annonce que vous recherchez n'existe pas :'(");
        } else {
            return $this->render('advert/index.html.twig', [
                'advert' => $advert,
                'questions' => $questions,
                'questionForm' => $questionForm->createView()
            ]);
        }
    }


    
    #[Route('/advert/{id}/delete', name: 'app_advert_delete', methods: ['GET', 'POST'])]
    public function deleteAdvert($id, AdvertRepository $advertRepository, QuestionRepository $questionRepository , Advert $advert) 
    {
        if($this->getUser() == $advert->getUserRegister()){
            $advertRepository->remove($advert, true);
        }
        //dd($advert->getQuestions());
        return $this->redirectToRoute('app_advert');
    }
}
