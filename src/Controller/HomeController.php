<?php

namespace App\Controller;

use App\Form\HomeType;
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
      
         $homeForm = $this->createForm(HomeType::class);
         $filterForm = $this->createForm(FilterType::class);

         $homeForm->handleRequest($request);
         $cats = [];
 
         if ($homeForm->isSubmitted() && $homeForm->isValid()) {
             $filters = $homeForm->getData();
             $name = $filters['name'];
             $cats = $catRepository->findCatName($name);
         } else {
             $cats = $catRepository->findBy([], ["dateProfile" => "DESC"]);
         }
 
         $filterForm->handleRequest($request);
         if ($filterForm->isSubmitted() && $filterForm->isValid()) {
             $filters = $filterForm->getData();
             $cats = $catRepository->findByFilters($filters);
         }

         $breeds = $breedRepository->findAll();
 
         return $this->render('home/index.html.twig', [
             'cats' => $cats,
             'breeds' => $breeds,
             'homeForm' => $homeForm->createView(),
             'filterForm' => $filterForm->createView(),
         ]);
     }


    
}
