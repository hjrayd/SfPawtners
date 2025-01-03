<?php
 
namespace App\Controller;
 
use App\Entity\Cat;
use App\Entity\Like;
use App\Entity\Image;
use App\Form\CatType;
use App\Entity\Matche;
use App\Form\LikeType;
use App\Repository\CatRepository;
use App\Service\SendEmailService;
use App\Repository\LikeRepository;
use App\Repository\BreedRepository;
use App\Repository\ImageRepository;
use App\Repository\MatcheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
class CatController extends AbstractController
{
    //Le routage remplace le lien du controller + méthode + id qu'on appelait avant dans l'url du site
    #[Route('/cat', name: 'app_cat')]
    public function index(CatRepository $catRepository): Response //On fait passer directement le repository
    {
         $userLogin = $this->getUser();
        if(!$userLogin) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $cats = $catRepository->findBy([], ["dateProfile" => "DESC"]);
 
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

        //On récupère le User connecté pour ne pas avoir à le renseigner
        $user = $this->getUser();
        if(!$user){
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        //Instanciation d'un objet Cat
        $cat = new Cat();
 
      
 
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

            //On récupère les couleurs des chats depuis le formulaire et on les attributs chacune au chat
            $coatsCat = $form->get('coats')->getData();
            foreach ($coatsCat as $coat) {
                $cat->addCoat($coat);
                $coat->addCat($cat);
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

    #[Route('/cat/delete/{id}', name: 'delete_cat')]
    public function delete($id, CatRepository $catRepository, EntityManagerInterface $entityManager, MatcheRepository $matcheRepository, LikeRepository $likeRepository): Response //On fait passer directement le repository
    {
        $userLogin = $this->getUser();
        if(!$userLogin) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $cat = $catRepository->find($id);
       
            $likes = $likeRepository->findBy([
                'catOne' => $cat
            ]);
            foreach ($likes as $like) {
                $entityManager->remove($like);
            }

            $likes = $likeRepository->findBy([
                'catTwo' => $cat
            ]);

            foreach ($likes as $like)
            {
                $entityManager->remove($like);
            }

            $matches = $matcheRepository->findBy([
                'catOne' => $cat
            ]);

            foreach ($matches as $match) {
                $entityManager->remove($match);
            }

            $matches = $matcheRepository->findBy([
                'catTwo' => $cat
            ]);

            foreach ($matches as $match)
            {
                $entityManager->remove($match);
            }

            $entityManager->remove($cat);
            $entityManager->flush();
            $this->addFlash('message', $cat.' a bien été supprimé');
       

        return $this->redirectToRoute('app_home');

        
    }
 
 
    #[Route('/cat/{id}', name: 'show_cat')]
    public function show(Cat $cat, LikeRepository $likeRepository, SendEmailService $mail,EntityManagerInterface $entityManager, CatRepository $catRepository, MatcheRepository $matcheRepository, Request $request): Response
    {

            // On récupère le user connecté
            $user = $this->getUser();

            if(!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

            // On récupère tous les chats du user à l'aide du repository
            $cats = $user->getCats();

            $like = new Like(); //On crée un nouvel objet like
            
            // On crée le formulaire
            $form = $this->createForm(LikeType::class, $like, [
                'cats' => $cats, // Liste des chats de l'utilisateur qu'on passe en options
                'catOne' => $cat, // Le chat à liker passé en option également
            ]);

            // On traite le formulaire
            $form->handleRequest($request);

            //Si il est soumit et valide
            if ($form->isSubmitted() && $form->isValid()) {
                $like->setCatOne($cat); // On attribue au $catOne dans Like le chat qu'on like
                $catTwo = $form->get('catTwo')->getData(); // On récupère le chat qu'on a choisit dans la liste
                $like->setCatTwo($catTwo); //On attribut à $catTwo le chat qu'on a choisit

                
                //On vérifie que l'utilisateur n'a pas déjà liké ce chat
                $alreadyLike = $likeRepository -> findBy([
                    'catOne' => $cat, //Chat qu"on like
                    'catTwo' => $catTwo //Chat choisit via le formulaire
                ]);

                if($alreadyLike) {
                    $this->addFlash('message', 'Vous avez déjà liké ce chat'); //Message d'erreur
                } else {

                    if($cats->contains($cat)) 
                    {
                        $this->addFlash('message', 'Vous ne pouvez pas liker vos propres chats '); //Message de succès
                        return $this->redirectToRoute('show_cat', ['id' => $cat->getId()]); // On redirige vers la même page
                    };

                    $entityManager->persist($like); //On persist l'objet et on le stocke en BDD
                    $entityManager->flush();

                    $reverseLike = $likeRepository -> findOneBy ([
                        'catOne' => $catTwo,
                        'catTwo' => $cat
                    ]);
                    
                    if($reverseLike) {
                        $match = new Matche();
                        $match -> setCatOne($cat);
                        $match -> setCatTwo($catTwo);

                        $entityManager->persist($match); //On persist l'objet et on le stocke en BDD
                        $entityManager->flush();

                        $userOne = $cat->getUser(); //Propriétaire du catOne
                        $userTwo = $catTwo->getUser(); //Propriétaire du catTwo
                        $loginUrl = $this->generateUrl('app_login', [], UrlGeneratorInterface::ABSOLUTE_URL);

                        // Envoi d'une notification par email au pemier propriétaire
                        $mail->send(
                        'no-reply@pawtners.fr',
                        $userOne->getEmail(), 
                        'Nouveau match !', 
                        'new_match', 
                        [
                            'user' => $userOne,
                            'catOne' => $cat,
                            'catTwo' => $catTwo,
                            'loginUrl' => $loginUrl
                        ] 
                    );

                    // Envoi d'une notification par email au deuxième propriétaire
                    $mail->send(
                        'no-reply@pawtners.fr',
                        $userTwo->getEmail(), 
                        'Nouveau match !', 
                        'new_match', 
                        [
                            'user' => $userTwo,
                            'catOne' => $cat,
                            'catTwo' => $catTwo,
                            'loginUrl' => $loginUrl
                        ] 
                    );
                        // Message de succès
                        $this->addFlash('message', 'Félicitations ! ' . $catTwo . ' a matché avec ' . $cat . ' !');
                        } else {
                            // Message de succès pour le Like
                            $this->addFlash('message', 'Vous avez liké ' . $cat . ' !');
                        }
                    }
                }

                    //On rend le formulaire dans la vue et le chat dont l'id est passé dans l'URL
                    return $this->render('cat/show.html.twig', [
                        'cat' => $cat,
                        'form' => $form->createView(),
                        
                    ]);
    }   
}
 
