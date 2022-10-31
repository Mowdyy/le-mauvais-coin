<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Repository\AdvertRepository;
use App\Repository\AnswerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/question')]
class QuestionController extends AbstractController
{
    
    


    #[Route('add/{id}', name: 'app_question_add', methods: ['POST','GET'])]
    public function add($id,Request $request, QuestionRepository $questionRepository, AdvertRepository $advertRepository, AnswerRepository $answerRepository)
    {
        // $questionForm = $this->createForm(QuestionType::class);
        // $questionForm->handleRequest($request);
        // if($questionForm->isSubmitted() && $questionForm->isValid()){
            
        // }
        
        return $this->redirectToRoute('app_advert_page', [
            'id' => $id
        ]);
    }



    #[Route('/{id}/delete', name: 'app_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, QuestionRepository $questionRepository)
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $questionRepository->remove($question, true);
        }
        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }
}
