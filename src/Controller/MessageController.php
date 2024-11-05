<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
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
    #[Route('/message/send', name: 'new_message')]
    public function send(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());

            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash("message", "Votre message a bien été envoyé");
            return $this->redirectToRoute("app_message");
        }

        
        return $this->render("message/new.html.twig", [
            "formMessage" => $form->createView()
        ]);
    }

    //On affiche les messages reçus
    #[Route('/message/received', name: 'received_message')]
    public function received(EntityManagerInterface $entityManager, MessageRepository $messageRepository): Response
    {
        $user = $this->getUser();

        $correspondents = $messageRepository->findCorrespondents($user);
        return $this->render('message/received.html.twig', [
            'correspondents' => $correspondents,
        ]);
    }

    //Lorsque l'on clique sur un pseudo, on peut voir les messages envoyé par ce user
    #[Route('/message/show/{id}', name: 'show_message')]
    public function show($id, EntityManagerInterface $entityManager, MessageRepository $messageRepository): Response
    {

        $sender = $entityManager->getRepository(User::class)->find($id);

        if (!$sender) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $user=$this->getUser();

        $messages = $messageRepository->findBy([
            'sender'=> $sender,
            'receiver'=> $user,
        ]);

        return $this->render('message/show.html.twig', [
            'sender' => $sender,
            'messages' => $messages
        ]);
    }



}
