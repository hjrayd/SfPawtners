<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatController extends AbstractController
{
    //Le routage remplace le lien du controller + méthode + id qu'on appelait avant dans l'url du site
    #[Route('/cat', name: 'app_cat')]
    public function index(CatRepository $catRepository): Response
    {
        $cats = $catRepository->findBy([], ["name" => "ASC"]);

        //Redirection qui redirige l'utilisateur
        //render permet de faire le lien entre le controller et la vue
        return $this->render('cat/index.html.twig', [
            'cats' => 'cats',
        ]);
    }
}
