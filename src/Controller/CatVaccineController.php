<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatVaccineController extends AbstractController
{
    #[Route('/cat/vaccine', name: 'app_cat_vaccine')]
    public function index(): Response
    {
        return $this->render('cat_vaccine/index.html.twig', [
            'controller_name' => 'CatVaccineController',
        ]);
    }
}
