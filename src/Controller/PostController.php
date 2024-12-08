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
        $posts = $postRepository->findBy([], ["postDate" => "ASC"]);
        
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/delete/{id}', name: 'delete_post')]
    public function delete($id , PostRepository $postRepository, EntityManagerInterface $entityManager): Response //On fait passer directement le repository
    {
        $post = $postRepository -> find($id);

        $topicId = $post->getTopic()->getId();
        $entityManager -> remove($post);
        $entityManager->flush();
        $this->addFlash('message', 'Le post a bien été supprimé');

        return $this->redirectToRoute('show_topic', ['id' => $topicId]);

    }
}
