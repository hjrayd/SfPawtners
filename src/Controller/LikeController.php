<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Entity\Like;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    #[Route('/like', name: 'app_like')]
    public function index(): Response
    {
        return $this->render('like/index.html.twig', [
            'likes' => 'likes',
        ]);
    }

    //Création d'un nouvea like
    #[Route('/like/new/{id}', name: 'new_like')]
    public function new(Cat $cat, EntityManagerInterface $entityManager, LikeRepository $likeRepository, Request $request): Response
    {
        //On récupère le user connecté
        $user = $this->getUser();
        $request->get('user_cat_id');

        if($cat->getUser() === $user) {
            $this->addFlash('message' , 'Vous ne pouvez pas liker votre propre chat');
            return $this->redirectToRoute('show_cat', ['id' => $cat->getId()]);
        }

        //On vérifie qu'il n'y ai pas déjà un like entre cet utilisateur et le chat
        $like = $likeRepository -> findOneBy ([
            'cat' => $cat,
            'user' => $user
        ]);

        //Si il y a déjà eu like un message apparait et ça ne s'enregistre pas en BDD
        if ($like) {
           $entityManager-> remove($like);
           $entityManager->flush();
           $this->addFlash('message' , 'Like supprimé');
           return $this->redirectToRoute('show_cat', ['id' => $cat->getId()]);

        }

        else {

            //Sinon instanciation d'un nouvel objet Like
            $like = new Like ();
            $like->setUser($user); //on associe le user connecté à l'objet like
            $like->setCat($cat);//On associe l'id du chat passé en paramètre a l'objet like


            $entityManager->persist($like); //On persist notre objet like et on l'envoie en BDD
            $entityManager->flush();

            $this->addFlash('message', sprintf('Vous avez liké %s !', $cat)); //On utilise sprintf pour inclure la variable
            return $this->redirectToRoute('show_cat', ['id' => $cat->getId()]);
        }


    }
}
