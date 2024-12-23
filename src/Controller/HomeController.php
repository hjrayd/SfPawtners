<?php

namespace App\Controller;

use App\Form\FilterType;
use App\Repository\CatRepository;
use App\Repository\BreedRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(Request $request, CatRepository $catRepository, BreedRepository $breedRepository): Response
    {
        $breeds = $breedRepository->findAll();
        
        $form = $this->createForm(FilterType::class);

        $form->handleRequest($request);

        $cats = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();

            $cats = $catRepository->findByFilters($filters);
        } else {

             //On fait appel au catRepository afin de trouver tous les profils des chats et les afficher sur la page 'Home'
            $cats = $catRepository->findBy([], ["dateProfile" => "DESC"]);
        }

        return $this->render('home/index.html.twig', [
            'cats' => $cats,
            'form' => $form->createView(),
        ]);
    }

    
}
