<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BreedController extends AbstractController
{
    #[Route('/breed', name: 'app_breed')]
    public function index(): Response
    {
        return $this->render('breed/index.html.twig', [
            'controller_name' => 'BreedController',
        ]);
    }
}
