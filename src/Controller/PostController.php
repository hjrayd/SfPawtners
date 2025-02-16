<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepository): Response //On fait passer directement le repository
    {

        $userLogin=$this->getUser();
        if(!$userLogin) 
        {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }
        $posts = $postRepository->findBy([], ["postDate" => "ASC"]);
        
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/delete/{id}', name: 'delete_post')]
    public function delete($id , PostRepository $postRepository, EntityManagerInterface $entityManager): Response //On fait passer directement le repository
    {

        $userLogin=$this->getUser();
        if(!$userLogin) 
        {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $roles = $userLogin->getRoles();

        $post = $postRepository -> find($id);
        

        if(!$post) {
            $this->addFlash('message', 'Ce post n\'existe pas.');
            return $this->redirectToRoute('app_category');
        }

        $topicId = $post->getTopic()->getId();

        if($post->getUser() === $userLogin || in_array("ROLE_ADMIN", $roles))
        {
            $entityManager -> remove($post);
        $entityManager->flush();
        $this->addFlash('message', 'Le post a bien été supprimé');

        return $this->redirectToRoute('show_topic', ['id' => $topicId]);
        } else {
            $this->addFlash('message', 'Vous n\'avez pas les droits pour supprimer ce post');
            return $this->redirectToRoute('show_topic', ['id' => $topicId]);
        }

    }
}
