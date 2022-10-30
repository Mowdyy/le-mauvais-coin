<?php

namespace App\Controller;

use App\Entity\UserRegister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{
    #[Route('/vote-up/{id}', name: 'app_vote_up')]
    public function voteUp($id, Request $request, UserRegister $user, EntityManagerInterface $entityManagerInterface)
    {
        $vote = $user->getVotes();
        $user->upVote($vote);

        $entityManagerInterface->flush();

        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }

    #[Route('/vote-down/{id}', name: 'app_vote_down')]
    public function voteDown($id, Request $request, UserRegister $user, EntityManagerInterface $entityManagerInterface)
    {
        $vote = $user->getVotes();
        $user->downVote($vote);

        $entityManagerInterface->flush();
        
        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }
}
