<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
    
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

    #[Route('/message/received', name: 'received_message')]
    public function received(): Response
    {
        return $this->render('message/received.html.twig');
    }

    #[Route('/message/show/{id}', name: 'show_message')]
    public function show(Message $message, EntityManagerInterface $entityManager): Response
    {
        $message->setIsRead(true);
        $entityManager->persist($message);
        $entityManager->flush();

        return $this->render('message/show.html.twig');
    }



}
