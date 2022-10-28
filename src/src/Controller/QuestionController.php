<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/question')]
class QuestionController extends AbstractController
{
    
    #[Route('add/{id}/{questionFormData}', name: 'app_question_add', methods: ['POST','GET'])]
    public function add($questionFormData,$id,Request $request, QuestionRepository $questionRepository, AdvertRepository $advertRepository)
    {
        // $questionForm = $this->createForm(QuestionType::class);
        // $questionForm->handleRequest($request);
        // if($questionForm->isSubmitted() && $questionForm->isValid()){
            
        // }
        $question = new Question();
        $advert = $advertRepository->findOneById($id);

        $question->setTitle($questionFormData);
        $question->setAdvert($advert);
        $question->setUserRegister($this->getUser());
        $questionRepository->save($question, true);
        return $this->redirectToRoute('app_advert_page', [
            'id' => $id
        ]);
    }



    #[Route('/{id}', name: 'app_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, QuestionRepository $questionRepository)
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $questionRepository->remove($question, true);
        }
        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }
}
