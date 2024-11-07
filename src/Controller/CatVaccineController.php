<?php

namespace App\Controller;

use App\Entity\CatVaccine;
use App\Form\CatVaccineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatVaccineController extends AbstractController
{
    #[Route('/cat/vaccine', name: 'app_cat_vaccine')]
    public function index(): Response
    {
        return $this->render('cat_vaccine/index.html.twig', [
            'catVaccines' => 'catVaccines',
        ]);
    }

    #[Route('/cat/vaccine/new', name: 'new_cat_vaccine')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

            $catVaccine = new CatVaccine();
     
        $form = $this->createForm(CatVaccineType::class, $catVaccine);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $catVaccine = $form->getData();
            //prepare
            $entityManager->persist($catVaccine);
            //execute
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('cat_vaccine/new.html.twig', [
            'formAddCatVaccine' => $form,
            
        ]);
    }
}
