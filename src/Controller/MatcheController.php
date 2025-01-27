<?php

namespace App\Controller;

use App\Repository\LikeRepository;
use App\Repository\MatcheRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/matche/delete/{id}', name: 'delete_matche')]
    public function delete(int $id, LikeRepository $likeRepository, MatcheRepository $matcheRepository, EntityManagerInterface $entityManager): Response
    {
        $userLogin = $this->getUser(); //On récupère l'utilisateur connecté
        if(!$userLogin) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $match = $matcheRepository->find($id); //On recherche l'id du match passé dans l'URL
        if (!$match){
            $this->addFlash('error', 'Le match n\'existe pas.');
            return $this->redirectToRoute('app_matche');

        }

        $likeOne = $likeRepository-> findOneBy ([
            'catOne' => $match->getCatOne(),
            'catTwo' => $match->getCatTwo()
        ]);

        $likeTwo = $likeRepository -> findOneBy ([
            'catOne' => $match->getCatTwo(),
            'catTwo' => $match->getCatOne()
        ]);

        if($likeOne) {
            $entityManager->remove($likeOne);
        };

        if($likeTwo) {
            $entityManager->remove($likeTwo);
        };

        $entityManager->remove($match);
        $entityManager->flush();

        $this->addFlash('message', 'Le match a été supprimé.');

        return $this->redirectToRoute('app_matche');
    }
}
