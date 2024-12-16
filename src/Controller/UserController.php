<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditPseudoType;
use App\Form\EditPasswordType;
use App\Repository\CatRepository;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\TopicRepository;
use App\Repository\MatcheRepository;
use App\Repository\MessageRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository ->findBy([], ["pseudo" => "ASC"]);
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/user/delete', name: 'delete_user')]
    public function delete( 
    Security $security,  EntityManagerInterface $entityManager, SessionInterface $session, TokenStorageInterface $tokenStorage, 
    CatRepository $catRepository, LikeRepository $likeRepository, MatcheRepository $matcheRepository, MessageRepository $messageRepository, 
    PostRepository $postRepository, CategoryRepository $categoryRepository, TopicRepository $topicRepository): Response 
    {
        $user = $security->getUser();

        if($user) {

            $cats = $catRepository->findBy([
                'user' => $user
            ]);

            if($cats) {
                foreach($cats as $cat) {
                    $likeCatOne = $likeRepository->findBy([
                        'catOne' => $cat
                    ]);
    
                    $likeCatTwo = $likeRepository->findBy([
                        'catTwo' => $cat
                    ]);
                }
    
                foreach($likeCatOne as $like) {
                    $entityManager->remove($like);
                }
    
                foreach($likeCatTwo as $like) {
                    $entityManager->remove($like);
                }
    
    
                foreach($cats as $cat) {
                    $matchCatOne = $matcheRepository->findBy([
                        'catOne' => $cat
                    ]);
    
                    $matchCatTwo = $matcheRepository->findBy([
                        'catTwo' => $cat
                    ]);
                }
    
                foreach($matchCatOne as $match) {
                    $entityManager->remove($match);
                }
    
                foreach($matchCatTwo as $match) {
                    $entityManager->remove($match);
                }
            }

            $messages = $messageRepository->findBy([
                'sender'=>$user
            ]);

            if($messages) {
                foreach($messages as $message) {
                    $entityManager->remove($message);
                }
                $messages = $messageRepository->findBy([
                    'receiver'=>$user
                ]);
    
                foreach($messages as $message) {
                    $entityManager->remove($message);
                }
            }

            $posts = $postRepository->findBy([
                "user" => $user
            ]);

            if ($posts) {
                foreach ($posts as $post) {
                    $post->setUser(null);
                }
            }

            $topics = $topicRepository->findBy([
                "user" => $user
            ]);

            if ($topics) {
                foreach ($topics as $topic) {
                    $topic->setUser(null);
                }
            }

            $entityManager->remove($user);
            $entityManager->flush();
            $session->invalidate(); //On supprime la session et ses données du user
            $tokenStorage->setToken(null);//On supprime le token d'authentification du user ce qui le déconnecte de suite et évite les erreurs de rafraichissement
            return $this->redirectToRoute('app_register');
        } else {
            throw $this->createAccessDeniedException('Vous n\'êtes pas connecté');
        }
    }



    #[Route('/user/{id}', name: 'show_user')]
    public function show(User $user, CatRepository $catRepository, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response {
        if(!$user) {
            return $this->redirectToRoute('app_register');
        }

        $formPseudo = $this->createForm(EditPseudoType::class, $user);
        $formPseudo->handleRequest($request);

        $formPassword = $this->createForm(EditPasswordType::class, $user);
        $formPassword->handleRequest($request);

        if($formPseudo->isSubmitted() && $formPseudo->isValid()) {
            $newPseudo = $formPseudo->get('pseudo')->getData();
            if($newPseudo) {
                $user->setPseudo($newPseudo);
               $entityManager->persist($user);
               $entityManager->flush();
               $this->addFlash('message', 'Votre pseudo a bien été modifier');
            }
            return $this->redirectToRoute('show_user', ['id'=>$user->getId()]);
        }

        if($formPassword->isSubmitted() && $formPassword->isValid()) {
            $newPassword = $formPassword->get('plainPassword')->getData();
            if($newPassword) {
              $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
              $user->setPassword($hashedPassword);
              $entityManager->persist($user);
              $entityManager->flush();
              $this->addFlash('message', 'Votre mot de passe a bien été modifier');
            }
            return $this->redirectToRoute('show_user', ['id'=>$user->getId()]);
        }
            $cats = $user->getCats();
            return $this->render('user/show.html.twig', [
                'user' => $user,
                'cats' => $cats, 
                'formPassword'=>$formPassword->createView(),
                'formPseudo'=>$formPseudo->createView(),

            ]);
        
    }



}
