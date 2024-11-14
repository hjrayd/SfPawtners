<?php

namespace App\Controller;

use App\Repository\MatchesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatchesController extends AbstractController
{
   //Le routage remplace le lien du controller + méthode + id qu'on appelait avant dans l'url du site
   #[Route('/matches', name: 'app_matches')]
   public function index(MatchesRepository $matchesRepository): Response //On fait passer directement le repository
   {
       $matches = $matchesRepository->findAll();

       //Redirection qui redirige l'utilisateur
       //render permet de faire le lien entre le controller et la vue
       return $this->render('matches/index.html.twig', [
           'matches' => $matches,
       ]);
   }
}
