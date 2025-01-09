<?php

namespace App\Controller;


use App\Service\JWTService;
use App\Form\ResetPasswordType;
use App\Service\SendEmailService;
use App\Repository\UserRepository;
use App\Form\ResetPasswordRequestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security): Response
    {

 
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = $this->getUser();
        //Si l'utilisateur n'as pas confirmer son adresse mail on renvoie vers une page d'erreur
        if($user && !$user->isVerified()){
            $this->render('user/verified.html.twig');
        }
            
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
    public function reset(Request $request, SendEmailService $mail, UserRepository $userRepository, JWTService $jwt): Response 
    {
        $form = $this->createForm(ResetPasswordRequestType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //On recherche l'utilisateur dans la BDD
            $user = $userRepository->findOneByEmail($form->get('email')->getData()); //On récupère l'email transmis via le formulaire pour retrouver l'utilisateur

            //On vérifie que l'email existe en BDD

            if($user) //L'email existe 
            {

            //Création du header
              $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
              ];

              //Création du contenu (payload)
              $payload = [
                'user_id' => $user->getId()
              ];

              //On génère le token
              $token = $jwt->generate($header, $payload,
              $this->getParameter('app.jwtsecret'));

              //On génère l'url vers app_resetPassword
              $url = $this->generateUrl('app_resetPassword', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

              $mail->send(
                'no-reply@pawtners.fr',
                $user->getEmail(),
                'Récuperation de mot de passe pour le site Pawtners',
                'passwordReset',
                compact('user', 'url') // Equivaut à ['user' => $user, 'url'=>$url]
              );

              $this->addFlash('message', 'L\'email à été envoyé à l\'adresse fournie');
              return $this->redirectToRoute('app_login');

            }

            $this->addFlash('message', 'Un problème est survenu');
            return $this->redirectToRoute('app_login');
            
        }

        return $this->render('security/passwordResetRequest.html.twig', [
            'formRequest' => $form->createView()
        ]);
    }

    #[Route(path: '/resetPassword/{token}', name: 'app_resetPassword')]
    public function resetPassword(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, Request $request, UserRepository $userRepository, $token, JWTService $jwt): Response 
    {

        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret')))
        {
            $payload = $jwt->getPayload($token);

            $user = $userRepository->find($payload['user_id']);

            if($user){
                $form = $this->createForm(ResetPasswordType::class);

                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid())
                {
                    $user->setPassword(
                        $passwordHasher->hashPassword($user, $form->get('plainPassword')->getData())
                    );

                    $entityManager->flush();

                    $this->addFlash('message', 'Votre mot de passe à bien été modifier');
                    return $this->redirectToRoute('app_login');
                }
                return $this->render('security/passwordReset.html.twig', [
                    'formPassword' => $form->createView()
                ]);
            }
        }
        $this->addFlash('message', 'Le token est invalide ou à expiré');
        return $this->redirectToRoute('app_login');


    }




}
