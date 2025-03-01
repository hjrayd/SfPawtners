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
    //Affichage des pseudo avec qui on a échangé
    #[Route('/message', name: 'app_message')]
    public function index(EntityManagerInterface $entityManager, MessageRepository $messageRepository): Response
    {
         //On récupère le user connecté et on le stocke
        $user = $this->getUser();
        if(!$user) 
    {
        throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
    }

         //On utilise notre requête DQL pour trouver les correspondants du user
        $correspondents = $messageRepository->findCorrespondents($user);
       

         //On retourne le résultat avec les correspondants
        return $this->render('message/index.html.twig', [
            'correspondents' => $correspondents,
            // 'lastMessage' => $lastMessage
        ]);
    }
    


    //Lorsque l'on clique sur un pseudo, on peut voir les messages envoyé par ce user
    #[Route('/message/show/{id}', name: 'show_message')]
    public function show($id, EntityManagerInterface $entityManager, UserRepository $userRepository,  MessageRepository $messageRepository, Request $request): Response
    {
        //On stocke le user connecté dans la variable $user
        $user=$this->getUser();
        
        if(!$user) 
        {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

    
        //On interroge la BDD pour associer le paramètre receiver à $id
        $receiver = $userRepository->find($id);

        if(!$receiver) {
            $this->addFlash('message', 'Cet utilisateur n\'existe pas.');
            return $this->redirectToRoute('app_cat');
        }

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
            $message->setSender($user);

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
