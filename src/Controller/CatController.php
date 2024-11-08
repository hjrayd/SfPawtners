<?php
 
namespace App\Controller;
 
use App\Entity\Cat;
use App\Entity\Image;
use App\Form\CatType;
use App\Repository\CatRepository;
use App\Repository\LikeRepository;
use App\Repository\BreedRepository;
use App\Repository\ImageRepository;
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
        SluggerInterface $slugger, // slugger formate les URL pour les simplifer
        #[Autowire('%pictures_directory%')] string $picturesDirectory, // injection de dépendance -> on injecte la dépendance au lieu de la créer dans la classe même
        BreedRepository $breedRepository,
        ImageRepository $imageRepository
    ): Response {
 
        //Instanciation d'un objet Cat
        $cat = new Cat();
 
        // $breeds = $breedRepository->findBy([], ['breedName' => 'ASC']);
 
        //On récupère le User connecté pour ne pas avoir à le renseigner
        $user = $this->getUser();
 
        //On attribut le user connecté à l'objet Cat
        $cat->setUser($user);
 
        //On crée une instance de formulaire basé sur l'entité Cat
        $form = $this->createForm(CatType::class, $cat);
 
        //Gestion de la soumission du formulaire
        $form->handleRequest($request);
 
        // On vérifie que le formulaire a bien été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
       
            //On récupère les données du formulaire
            $cat = $form->getData();
 
            //On récupère les races des chats depuis le formulaire et on les attributs chacune au chat
            $breedsCat = $form->get('breeds')->getData();
            foreach ($breedsCat as $breed) {
                $cat->addBreed($breed);
                $breed->addCat($cat);
            }

            // On récupère les images uploadés -> $pictures correspond à l'image qu'on upload
            $pictures = $form->get('images')->getData();
            
            //on vérifie que l'on récupère bien un tableau et que les images ont bien été uploadé
            if (!empty($pictures) && is_array($pictures)) {
 
                //on parcourt chaque image
                foreach ($pictures as $picture) {
                    if ($picture) {
                        
                        //On crée une nouvelle instance de l'entité Image -> $image = nouvel instanciation de l'entité Image
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
            try {
                // On persist le chat et les images associés
                $entityManager->persist($cat);
                //On envoie les données dans la base de données
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
            }
            return $this->redirectToRoute('app_home'); // Redirection si succès
        } else {
 
            // Si le formulaire n'est pas soumis ou valide, on renvoie la vue du formulaire
            return $this->render('cat/new.html.twig', [
                'formAddCat' => $form->createView(),
            ]);
        }
    }
 
 
    #[Route('/cat/{id}', name: 'show_cat')]
    public function show(Cat $cat, LikeRepository $likeRepository): Response
    {
        $user = $this->getUser();
        
        $like = $likeRepository -> findOneBy ([
            'cat' => $cat,
            'user' => $user
        ]);
        
        if($like ){
            $alreadyLike = true;
        } else {
            $alreadyLike = false;
        }
 
        return $this->render('cat/show.html.twig', [
            'cat' => $cat,
            'alreadyLike' => $alreadyLike
        ]);  
    }
 
}