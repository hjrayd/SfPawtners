<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
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

    #[Route('/category/delete/{id}', name: 'delete_category')]
    public function delete($id , CategoryRepository $categoryRepository, EntityManagerInterface $entityManager): Response //On fait passer directement le repository
    {
        $category = $categoryRepository -> find($id);

        $entityManager -> remove($category);
        $entityManager->flush();
        $this->addFlash('message', 'La catégorie a bien été supprimée');

        return $this-> redirectToRoute('app_category');

    }

}
