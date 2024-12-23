<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    #[Route('/review', name: 'app_review')]
    public function index(): Response
    {
        return $this->render('review/index.html.twig', [
            'controller_name' => 'ReviewController',
        ]);
    }

    #[Route('/review/delete/{id}', name: 'delete_review')]
    public function delete(int $id, ReviewRepository $reviewRepository, EntityManagerInterface $entityManager): Response
    {
        $review = $reviewRepository->find($id);

        $user = $this->getUser();

        if($review->getReviewer() !== $user ) {
            $this->addFlash('message', 'Vous ne pouvez pas supprimé cet avis');
            return $this->redirectToRoute('show_user', ['id' => $review->getReviewee()->getId()]);
        }

        $entityManager -> remove($review);
        $entityManager -> flush();

        $this->addFlash('message', 'Votre avis à bien été supprimé');
        return $this->redirectToRoute('show_user', ['id' => $review->getReviewee()->getId()]);


    }

    
}
