<?php

namespace App\Controller;

use App\Form\CatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddCatController extends AbstractController
{
    #[Route('/add/cat', name: 'app_add_cat')]
    public function index(): Response
    {
        return $this->render('add_cat/index.html.twig', [
            'controller_name' => 'AddCatController',
        ]);
    }

 

}




