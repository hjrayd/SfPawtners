<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Form\ResetPasswordRequestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/reset', name: 'app_reset')]
    public function reset(Request $request, UserRepository $userRepository): Response 
    {
        $form = $this->createForm(ResetPasswordRequestType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //On recherche l'utilisateur dans la BDD
            $user = $userRepository->findOneByEmail($form->get('email')->getData()); //On récupère l'email transmis via le formulaire pour retrouver l'utilisateur

            //On vérifie que l'email existe en BDD

            if(!$user) //L'email n'existe pas
             {
               $this->addFlash('message', 'Un problème est survenu');
               return $this->redirectToRoute('app_login');
            }

            //L'email existe 
            
        }

        return $this->render('security/reset.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
