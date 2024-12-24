<?php

namespace App\Controller;

use App\Form\UserFilterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $userRepository, Request $request): Response
    {
            $users = $userRepository->findBy([], ['pseudo' => 'ASC']);
        

        return $this->render('admin/index.html.twig', [
            'users' => $users,

        ]);
    
    }

    #[Route('/admin/ban/{id}', name: 'ban_admin')]
    public function ban(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);

        if(!$user) {
            $this->addFlash('message', 'Utilisateur introuvable');
            return $this->redirectToRoute('app_admin');
        }

        $user->setBan(true);
        $entityManager->flush();

        $this->addFlash('message', 'L\'utilisateur à bien été banni');
        return $this->redirectToRoute('app_admin');


    }

    #[Route('/admin/unban/{id}', name: 'unban_admin')]
    public function unban(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);

        if(!$user) {
            $this->addFlash('message', 'Utilisateur introuvable');
            return $this->redirectToRoute('app_admin');
        }

        $user->setBan(false);
        $entityManager->flush();

        $this->addFlash('message', 'L\'utilisateur à bien été débanni');
        return $this->redirectToRoute('app_admin');

    }



}
