<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(EntityManagerInterface $entityManager, MessageRepository $messageRepository ): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
    
    //On gère le formulaire d'envoie de message
    #[Route('/message/new/{id}', name: 'new_message')]
    public function new(int $id, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        $receiver = $userRepository->find($id);
        //Instanciation d'un nouvel objet message
        $message = new Message();

        //On crée le formulaire
        $form = $this->createForm(MessageType::class, $message, [
            'receiver' => $receiver
        ]);

        //On associe les données de la requête au formulaire
        $form->handleRequest($request);

        //Si le formulaire et soumis et valide
        if($form->isSubmitted() && $form->isValid()) {

            //On attribut à l'expediteur du message l'id du user connecté
            $message->setSender($user);
            $message->setReceiver($receiver);

            //On persiste et envoie les données en BDD
            $entityManager->persist($message);
            $entityManager->flush();

            //Message de succès
            $this->addFlash("message", "Votre message a bien été envoyé");
            return $this->redirectToRoute("show_message", ['id' => $id]);
        }

        //On retourne le resultat avec le formulaire dans la vue
        return $this->render("message/new.html.twig", [
            "formMessage" => $form->createView()
        ]);
    }

    //On affiche les pseudos des gens a qui on a envoyé/reçu un message
    #[Route('/message/received', name: 'received_message')]
    public function received(EntityManagerInterface $entityManager, MessageRepository $messageRepository): Response
    {
        //On récupère le user connecté et on le stocke
        $user = $this->getUser();

         //On utilise notre requête DQL pour trouver les correspondants du user
         $correspondents = $messageRepository->findCorrespondents($user);

         //On retourne le résultat avec les correspondants
        return $this->render('message/received.html.twig', [
            'correspondents' => $correspondents,
        ]);
    }

    //Lorsque l'on clique sur un pseudo, on peut voir les messages envoyé par ce user
    #[Route('/message/show/{id}', name: 'show_message')]
    public function show($id, EntityManagerInterface $entityManager, MessageRepository $messageRepository, Request $request): Response
    {

        //On interroge la BDD pour associer le paramètre receiver à $id
        $receiver = $entityManager->getRepository(User::class)->find($id);

        //On stocke le user connecté dans la variable $user
        $user=$this->getUser();

        //On utilise notre requête DQL pour afficher tous les messages entre deux userss
        $messages = $messageRepository->findAllMessages($user, $receiver);

        //Instanciation d'un nouvel objet message
        $message = new Message();

        //On crée le formulaire
        $form = $this->createForm(MessageType::class, $message, [
            'receiver' => $receiver //on passe le receiver en option pour ne pas avoir a choisir un destinataire
        ]);

        $form ->handleRequest($request);

        //Si le formulaire et soumis et valide
        if($form->isSubmitted() && $form->isValid()) {

            //On attribut à l'expediteur du message l'id du user connecté
            $message->setSender($this->getUser());

            //On attribue au receiver le user passé en paramètre de la fonction 
            $message->setReceiver($receiver);


            //On persiste et envoie les données en BDD
            $entityManager->persist($message);
            $entityManager->flush();
           
            //On redirige vers la conversation avec le user dont l'id et passé en paramètre
            return $this->redirectToRoute("show_message", ['id' => $id]);
        }


        //On affiche le résultat dans notre vue show
        //On retourne les messages et le destinataire
        return $this->render('message/show.html.twig', [
            'receiver' => $receiver,
            'messages' => $messages, 
            'formMessage' => $form->createView(),
        ]);
    }



}
