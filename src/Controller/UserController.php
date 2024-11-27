<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CatRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository ->findBy([], ["pseudo" => "ASC"]);
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/user/delete', name: 'delete_user')]
    public function delete( Security $security,  EntityManagerInterface $entityManager, SessionInterface $session, TokenStorageInterface $tokenStorage): Response 
    {
        $user = $security->getUser();

        if($user) {
            $entityManager->remove($user);
            $entityManager->flush();
            $session->invalidate(); //On supprime la session et ses données du user
            $tokenStorage->setToken(null);//On supprime le token d'authentification du user ce qui le déconnecte de suite et évite les erreurs de rafraichissement
            return $this->redirectToRoute('app_register');
        } else {
            throw $this->createAccessDeniedException('Vous n\'êtes pas connecté');
        }
    }



    #[Route('/user/{id}', name: 'show_user')]
    public function show(User $user, CatRepository $catRepository): Response {
        if(!$user) {
            return $this->redirectToRoute('app_register');
        }

        $cats = $user->getCats();
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'cats' => $cats
        ]);
        
    }



}
