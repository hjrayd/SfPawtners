<?php

namespace App\Controller;

use App\Repository\MatchesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatchesController extends AbstractController
{
    #[Route('/matches', name: 'app_matches')]
    public function index(MatchesRepository $matchesRepository): Response
    {
        $user = $this->getUser();

        $userCats = $user->getCats()->toArray();

        $userMatches = $matchesRepository->findMatches($userCats);

        return $this->render('matches/index.html.twig', [
            'userMatches' => $userMatches,
        ]);
    }
}
