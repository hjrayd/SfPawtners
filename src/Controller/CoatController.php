<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoatController extends AbstractController
{
    #[Route('/coat', name: 'app_coat')]
    public function index(): Response
    {
        return $this->render('coat/index.html.twig', [
            'controller_name' => 'CoatController',
        ]);
    }
}
