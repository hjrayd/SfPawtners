<?php

namespace App\Controller;

use App\Entity\Like;
use App\Form\LikeType;
use App\Repository\CatRepository;
use App\Repository\LikeRepository;
use App\Repository\MatcheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    #[Route('/like', name: 'app_like')]
    public function index(LikeRepository $likeRepository): Response
    {
        $user = $this->getUser();
        if(!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $catsUser = $user->getCats()->toArray();

        $userLikes = $likeRepository->findBy(['catTwo' => $catsUser]);

        return $this->render('like/index.html.twig', [
            'userLikes' => $userLikes,
        ]);
    }

    #[Route('/like/delete/{id}', name: 'delete_like')]
    public function delete($id, LikeRepository $likeRepository, MatcheRepository $matcheRepository, EntityManagerInterface $entityManager): Response
    {
        $userLogin = $this->getUser(); //On récupère l'utilisateur connecté
        if(!$userLogin) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $like = $likeRepository->find($id); //On recherche l'id du like passé dans l'URL
        if(!$like) {
            $this->addFlash('message', 'Ce like n\'existe pas');
            return $this->redirectToRoute('app_cat');
        }

    
        $userCats = $userLogin->getCats()->toArray();
        if (!in_array($like->getCatTwo(), $userCats)) {
            $this->addFlash('message', 'Vous n\'avez pas les droits pour supprimer ce like.');
            return $this->redirectToRoute('app_like');
        }




        $match = $matcheRepository-> findOneBy ([
            'catOne' => $like->getCatOne(),
            'catTwo' => $like->getCatTwo()
        ]);

        $matchOne = $matcheRepository -> findOneBy ([
            'catOne' => $like->getCatTwo(),
            'catTwo' => $like->getCatOne()
        ]);

        if($match) {
            $entityManager->remove($match);
        };

        if($matchOne) {
            $entityManager->remove($matchOne);
        };

        $entityManager->remove($like);
        $entityManager->flush();

        $this->addFlash('message', 'Le like a été supprimé.');

        return $this->redirectToRoute('app_like');
    }


}



