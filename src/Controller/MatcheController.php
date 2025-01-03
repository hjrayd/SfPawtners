<?php

namespace App\Controller;

use App\Repository\MatcheRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatcheController extends AbstractController
{
    #[Route('/matche', name: 'app_matche')]
    public function index(MatcheRepository $matcheRepository): Response
    {
        $user = $this->getUser();
        if(!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $userCats = $user->getCats()->toArray();

        $userMatches = $matcheRepository->findMatches($userCats);

        return $this->render('matche/index.html.twig', [
            'userMatches' => $userMatches,
        ]);
    }
}
