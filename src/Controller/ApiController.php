<?php

namespace App\Controller;

use App\HttpClient\ApiHttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ApiController extends AbstractController{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    #[Route('/breeds', name: 'app_breeds')]
    public function breeds(ApiHttpClient $apiHttpClient): Response 
    {
        $breeds = $apiHttpClient->getBreeds(); //On récupère les races des chats à l'aide de la méthode getBreeds()
        return $this->render('api/index.html.twig', [
            'breeds' => $breeds,
        ]);
    }
}