<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Entity\Image;
use App\Form\CatType;
use App\Repository\CatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
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
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        #[Autowire('%pictures_directory%')] string $picturesDirectory
    ): Response {
        $cat = new Cat();
        $user = $this->getUser();
        $cat->setUser($user);

        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);

        // On vérifie que le formulaire a bien été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $cat = $form->getData();

            // On récupère les images uploadés 
            $pictures = $form->get('images')->getData(); 

            //on vérifie que l'on récupère bien un tableau et que les images ont bien été uploadé
            if (!empty($pictures) && is_array($pictures)) {
                foreach ($pictures as $picture) { 
                    if ($picture) {

                        //On crée une nouvelle instance de l'entité Image
                        $image = new Image(); 

                        //On utilise le nom du chat pour créer l'alt automatiquement
                        $image->setImageAlt($cat->getName());

                        //On établit le lien entre le chat et l'image
                        $image->setCat($cat);

                        // On renomme chaque fichiers pour éviter les conflits de noms
                        $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeFilename = $slugger->slug($originalFilename);
                        $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();

                        try {
                            // On déplace le fichier dans le dossier spécifié
                            $picture->move($picturesDirectory, $newFilename);
                        } catch (FileException $e) {

                            // Si l'upload rencontre un problème on affiche un message d'erreur
                            $this->addFlash('error', 'Erreur lors de l\'upload de l\'image : ' . $e->getMessage());

                            //Et on redirige vers le formulaire
                            return $this->redirectToRoute('new_cat');
                        }

                        //On définit le chemin de l'image
                        $image->setImageLink('/uploads/pictures/' . $newFilename);

                        // On persist l'image et on ajoute l'image au chat spécifié
                        $entityManager->persist($image);
                        $cat->addImage($image);
                    }
                }
            }

            // On persist le chat et les images associés
            $entityManager->persist($cat);
            $entityManager->flush();

            return $this->redirectToRoute('app_home'); // Redirection si succès
        }

        // Si le formulaire n'est pas soumis ou valide, on renvoie la vue du formulaire
        return $this->render('cat/new.html.twig', [
            'formAddCat' => $form->createView(),
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
