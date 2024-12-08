<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/topic/delete/{id}', name: 'delete_topic')]
    public function delete($id , TopicRepository $topicRepository, EntityManagerInterface $entityManager): Response //On fait passer directement le repository
    {
        $topic = $topicRepository -> find($id);

        $categoryId = $topic->getCategory()->getId();
        $entityManager -> remove($topic);
        $entityManager->flush();
        $this->addFlash('message', 'Le topic a bien été supprimé');

        return $this->redirectToRoute('show_category', ['id' => $categoryId]);

    }
}
