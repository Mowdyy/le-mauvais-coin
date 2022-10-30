<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Question;
use App\Entity\Answer;
use App\Form\AdvertType;
use App\Form\QuestionType;
use App\Form\SearchAdvertType;
use App\Form\AnswerType;
use App\Repository\AdvertRepository;
use App\Repository\AnswerRepository;
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
                if ($image) {
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                    
                    try {
                        $image->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        dd($e);
                    }
                    $advert->setImageFileName($newFilename);
                }
                                
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
    public function findAdvertById(AnswerRepository $answerRepository ,QuestionRepository $questionRepository,EntityManagerInterface $entityManagerInterface,Request $request,$id, AdvertRepository $advertRepository): Response
    {
        /** gestion du formulaire pour ajouter une question à l'annonce */
        $question = new Question();
        $advert = $advertRepository->findOneById($id);
        $questions = $advert->getQuestions();
        $questionForm = $this->createForm(QuestionType::class, $question);
        $questionForm->handleRequest($request);
        if($questionForm->isSubmitted() && $questionForm->isValid()){
            //dd($questionForm->getData());
            $question->setTitle($questionForm->getData()->getTitle())
                        ->setUserRegister($this->getUser());
                        
            $advert->addQuestion($question);
            $entityManagerInterface->persist($advert);
            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_advert_page', [
                'id' => $id
            ]);
        }

        /** gestion du formulaire pour répondre à une question */
        $answer = new Answer();
        $answerForm = $this->createForm(AnswerType::class, $answer);
        $answerForm->handleRequest($request);
        if($answerForm->isSubmitted() && $answerForm->isvalid()){
            $questionId = $answerForm->get('questionId')->getData();
            if($questionId){
                $answer->setAnswer($answerForm->getData()->getAnswer())
                        ->setQuestion($questionRepository->find($questionId))
                        ->setUser($this->getUser());
                $answerRepository->save($answer, true);
                return $this->redirectToRoute('app_advert_page', [
                    'id' => $id
                ]);
            }
        }   

        
        /** vérification de la présence de l'annonce */
        if (!$advert) {
            throw $this->createNotFoundException("L'annonce que vous recherchez n'existe pas :'(");
        } else {
            return $this->render('advert/index.html.twig', [
                'advert' => $advert,
                'questions' => $questions,
                'questionForm' => $questionForm->createView(),
                'answerForm' => $answerForm->createView()
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
