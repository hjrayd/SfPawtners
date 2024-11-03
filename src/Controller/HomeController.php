<?php

namespace App\Controller;

use App\Repository\CatRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[isGranted("ROLE_USER")]
class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(CatRepository $catRepository): Response
    {
        //On fait appel au catRepository afin de trouver tous les profils des chats et les afficher sur la page 'Home'
        $cats = $catRepository->findAll();
        return $this->render('home/index.html.twig', [
            'cats' => $cats
        ]);
    }
}
