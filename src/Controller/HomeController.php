<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $description = "Bienvenue sur pawtners ! Le site de rencontres pour chat. Inscrivez-vous ou connectez vous et découvrez de nombreux profils qui pourront correspondre à votre félin !";
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'description' => $description
        ]);
    }
}
