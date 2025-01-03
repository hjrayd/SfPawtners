<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager): Response //On fait passer directement le repository
    {
        $userLogin = $this->getUser();
        if(!$userLogin) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $categories = $categoryRepository->findBy([], ["categoryName" => "ASC"]);
        
        $category = new Category();
        $formCategory = $this->createForm(CategoryType::class, $category);
        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted() && $formCategory->isValid()) {
            $category = $formCategory -> getData();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('message', 'La catégorie a bien été ajoutée');

            return $this -> redirectToRoute('app_category');
        }
        
        //Redirection qui redirige l'utilisateur
        //render permet de faire le lien entre le controller et la vue
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'formCategory' => $formCategory->createView() 
        ]);
    }

    #[Route('/category/show/{id}', name: 'show_category')]
    public function show(int $id , CategoryRepository $categoryRepository, TopicRepository $topicRepository, Request $request, EntityManagerInterface $entityManager): Response //On fait passer directement le repository
    {  
        $user = $this->getUser();
        if(!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $category = $categoryRepository->find($id);
      

        $topic = new Topic();
        $topic->setCategory($category);
        $topic->setUser($user);


        $formTopic = $this->createForm(TopicType::class, $topic);
        $formTopic->handleRequest($request);

        if ($formTopic->isSubmitted() && $formTopic->isValid()) {
            $entityManager->persist($topic);
            $entityManager->flush();

            $this->addFlash('message', 'Le topic a bien été ajouté');

            return $this->redirectToRoute('show_category', ['id' => $category->getId()]);
        }
        
        //Redirection qui redirige l'utilisateur
        //render permet de faire le lien entre le controller et la vue
        return $this->render('category/show.html.twig', [
            'formTopic' => $formTopic->createView(),
            'category' => $category,
            'topics' => $category->getTopics()
        ]);

    }

    #[Route('/category/delete/{id}', name: 'delete_category')]
    public function delete($id , CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, TopicRepository $topicRepository, PostRepository $postRepository): Response //On fait passer directement le repository
    {
        $userLogin = $this->getUser();
        if(!$userLogin) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }
        
        $category = $categoryRepository -> find($id);
        $topics = $topicRepository -> findBy([
            "category" => $category
        ]);

        if($topics) {
            foreach ($topics as $topic) {
                $posts = $postRepository-> findBy([
                    "topic" => $topic
                ]);
                foreach ($posts as $post) {
                    $entityManager -> remove ($post);
                }
                $entityManager -> remove($topic);
            }
        }

        $entityManager -> remove($category);
        $entityManager->flush();
        $this->addFlash('message', 'La catégorie a bien été supprimée');

        return $this-> redirectToRoute('app_category');

    }

}
