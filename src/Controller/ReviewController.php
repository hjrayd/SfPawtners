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

        $user = $this->getUser();
        if(!$user) 
        {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $review = $reviewRepository->find($id);

        $role = $user->getRoles();

        
        if($review->getReviewer() !== $user && !in_array("ROLE_ADMIN", $role)) {
            $this->addFlash('message', 'Vous ne pouvez pas supprimé cet avis');
            return $this->redirectToRoute('show_user', ['id' => $review->getReviewee()->getId()]);
        }

        $entityManager -> remove($review);
        $entityManager -> flush();

        $this->addFlash('message', 'L\'avis à bien été supprimé');
        return $this->redirectToRoute('show_user', ['id' => $review->getReviewee()->getId()]);


    }

    
}
