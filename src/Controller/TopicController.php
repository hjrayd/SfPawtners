<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    #[Route('/topic', name: 'app_topic')]
    public function index(TopicRepository $topicRepository): Response //On fait passer directement le repository
    {
        $topics = $topicRepository->findBy([], ["topicDate" => "ASC"]);
        
        return $this->render('topic/index.html.twig', [
            'topics' => $topics,
        ]);
    }
    #[Route('/topic/show/{id}', name: 'show_topic')]
    public function show(int $id , TopicRepository $topicRepository, PostRepository $postRepository, Request $request, EntityManagerInterface $entityManager): Response //On fait passer directement le repository
    {
        $topic = $topicRepository->find($id);
        $user = $this->getUser();

        $post = new Post();
        $post->setTopic($topic);
        $post->setUser($user);


        $formPost = $this->createForm(PostType::class, $post);
        $formPost->handleRequest($request);

        if ($formPost->isSubmitted() && $formPost->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('message', 'Le post a bien été ajouté');

            return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);
        }
        
        //Redirection qui redirige l'utilisateur
        //render permet de faire le lien entre le controller et la vue
        return $this->render('topic/show.html.twig', [
            'formPost' => $formPost->createView(),
            'topic' => $topic,
            'posts' => $topic->getPosts()
        ]);

    }

    #[Route('/topic/lock/{id}', name: 'lock_topic')]
    public function lock($id , TopicRepository $topicRepository, EntityManagerInterface $entityManager): Response
    {
        $topic = $topicRepository -> find($id);
        $categoryId = $topic->getCategory()->getId();

        $topic -> setLocked(true);
        $entityManager -> persist($topic);
        $entityManager -> flush();

        return $this->redirectToRoute('show_category', ['id' => $categoryId]);


    }

    #[Route('/topic/unlock/{id}', name: 'unlock_topic')]
    public function unlock($id , TopicRepository $topicRepository, EntityManagerInterface $entityManager): Response
    {
        $topic = $topicRepository -> find($id);
        $categoryId = $topic->getCategory()->getId();

        $topic -> setLocked(false);
        $entityManager -> persist($topic);
        $entityManager -> flush();

        return $this->redirectToRoute('show_category', ['id' => $categoryId]);


    }

    #[Route('/topic/delete/{id}', name: 'delete_topic')]
    public function delete($id , TopicRepository $topicRepository, EntityManagerInterface $entityManager): Response
    {
        $topic = $topicRepository -> find($id);

        $categoryId = $topic->getCategory()->getId();
        $entityManager -> remove($topic);
        $entityManager->flush();
        $this->addFlash('message', 'Le topic a bien été supprimé');

        return $this->redirectToRoute('show_category', ['id' => $categoryId]);

    }
}
