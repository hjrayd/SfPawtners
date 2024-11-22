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

        $catsUser = $user->getCats()->toArray();

        $userLikes = $likeRepository->findBy(['catTwo' => $catsUser]);

        return $this->render('like/index.html.twig', [
            'userLikes' => $userLikes,
        ]);
    }

    #[Route('/like/delete/{id}', name: 'delete_like')]
    public function delete($id, LikeRepository $likeRepository, MatcheRepository $matcheRepository, EntityManagerInterface $entityManager): Response
   {
    $like = $likeRepository->find($id);

    $match = $matcheRepository-> findOneBy ([
        'catOne' => $like->getCatOne(),
        'catTwo' => $like->getCatTwo()
    ]);

    if($match) {
        $entityManager->remove($match);
    };

    $entityManager->remove($like);
    $entityManager->flush();

    $this->addFlash('message', 'Le like a été supprimé.');

    return $this->redirectToRoute('app_like');
   }


}



