<?php

namespace App\Controller;

use App\Entity\UserRegister;
use App\Entity\Vote;
use App\Form\RegistrationFormType;
use App\Repository\VoteRepository;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        if($this->getUser()){
            return $this->redirectToRoute('app_advert');
        }else{

            $user = new UserRegister();
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email
    
                return $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                );
            }
    
            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        }
    }

    #[Route('/{id}/vote', name: "app_user_vote", methods: ['GET', 'POST'])]
    public function userVote(UserRegister $user, Request $request, EntityManagerInterface $entityManager,  VoteRepository $voteRepository): Response
    {
        $fromUserID = $this->getUser()->getId();
        $toUserId = $user->getId();
        $vote = new Vote();

        if ($request->query->get('direction')) {
            $direction = $request->query->get('direction');
            if (!$voteRepository->hasVote($fromUserID, $toUserId, $direction)) {
                $vote->setFromUserId($fromUserID)->setToUserId($toUserId);
                // $direction == 'up' ? $user->upVote() : $user->downVote();
                $voteRepository->upDateVote($fromUserID, $toUserId, $direction);
                $vote->setDirection($direction);

                $entityManager->persist($vote);
                $entityManager->flush();
            }
        }
        $this->render('vote/vote.html.twig', [
            'user' => $user
        ]);
        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }

}
