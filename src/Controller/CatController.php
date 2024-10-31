<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Form\CatType;
use App\Repository\CatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatController extends AbstractController
{
    //Le routage remplace le lien du controller + méthode + id qu'on appelait avant dans l'url du site
    #[Route('/cat', name: 'app_cat')]
    public function index(CatRepository $catRepository): Response //On fait passer directement le repository
    {
        $cats = $catRepository->findBy([], ["name" => "ASC"]);

        //Redirection qui redirige l'utilisateur
        //render permet de faire le lien entre le controller et la vue
        return $this->render('cat/index.html.twig', [
            'cats' => $cats,
        ]);
    }

  
    #[Route('/cat/new', name: 'new_cat')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cat = new Cat();

        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {

            $cat = $form->getData();
            $entityManager->persist($cat);
            $entityManager->flush();

            return $this->redirectToRoute('app_cat');
        }

        return $this->render('cat/new.html.twig' , [
            'formAddCat' => $form,
        ]);
    }

    #[Route('/cat/{id}', name: 'show_cat')]
    public function show(Cat $cat): Response
    {

        return $this->render('cat/show.html.twig', [
            'cat' => $cat
        ]);   
    }

}
