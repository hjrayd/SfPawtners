<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Form\EditPseudoType;
use App\Form\EditPasswordType;
use App\Repository\CatRepository;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\TopicRepository;
use App\Repository\MatcheRepository;
use App\Repository\ReviewRepository;
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
  

    #[Route('/user/delete', name: 'delete_user')]
    public function delete( 
    Security $security,  EntityManagerInterface $entityManager, SessionInterface $session, TokenStorageInterface $tokenStorage, 
    CatRepository $catRepository, LikeRepository $likeRepository, MatcheRepository $matcheRepository, MessageRepository $messageRepository, 
    PostRepository $postRepository, CategoryRepository $categoryRepository, TopicRepository $topicRepository, ReviewRepository $reviewRepository): Response 
    {
       $user = $this->getUser();

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

            $reviews = $reviewRepository->findBy([
                "reviewer" => $user
            ]);

            if($reviews) {
                foreach($reviews as $review) {
                    $review->setReviewer(null);
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



    
    #[Route('/user/update', name: 'update_user')]
    public function update( Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response {

        $user = $this->getUser();
        if(!$user) 
        {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }
        
        $formPseudo = $this->createForm(EditPseudoType::class, $user);
        $formPseudo->handleRequest($request);
        
        if($formPseudo->isSubmitted() && $formPseudo->isValid()) {
            $newPseudo = $formPseudo->get('pseudo')->getData();
            if($newPseudo) {
                $user->setPseudo($newPseudo);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Votre pseudo a bien été modifier');
            }
            return $this->redirectToRoute('update_user');
        }
        
        $formPassword = $this->createForm(EditPasswordType::class, $user);
        $formPassword->handleRequest($request);
        
        if($formPassword->isSubmitted() && $formPassword->isValid()) {
            $newPassword = $formPassword->get('plainPassword')->getData();
            if($newPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('message', 'Votre mot de passe a bien été modifier');
            }
            return $this->redirectToRoute('update_user');
        }
        
        return $this->render('user/update.html.twig', [
            'user'=>$user,
            'formPassword'=>$formPassword->createView(),
            'formPseudo'=>$formPseudo->createView(),
            
        ]);
    }

    #[Route('/user/{id}', name: 'show_user')]
    public function show(int $id, User $user = null, CatRepository $catRepository, MessageRepository $messageRepository, ReviewRepository $reviewRepository, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response {
   

        //Formulaire d'ajout d'avis
        $reviewee = $userRepository->find($id);
        
        $reviewer = $this->getUser();
        if(!$reviewer) 
        {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $canPostReview = $messageRepository->findIfMessageExchanged($reviewee, $reviewer);
        $alreadyReviewed = $reviewRepository->findBy([
            "reviewer" => $reviewer,
            "reviewee" => $reviewee
        ]);

        $review = new Review();
        $formReview = $this->createForm(ReviewType::class, $review);
        $formReview->handleRequest($request);

        if($formReview->isSubmitted() && $formReview->isValid()) {
              if ($reviewee == $reviewer) {
                $this->addFlash('message', 'Vous ne pouvez pas vous notez vous même');
              } elseif($alreadyReviewed) {
                $this->addFlash('message', 'Vous avez déjà noté cet utilisateur');
              } else {
                $review->setReviewer($reviewer);
                $review->setReviewee($reviewee);
                $entityManager->persist($review);
                $entityManager->flush();
                $this->addFlash('message', 'Votre avis a bien été mis en ligne');
              }
              return $this->redirectToRoute('show_user', ['id'=>$user->getId()]);
            } 
        $reviews = $reviewRepository -> findBy([
            "reviewee" => $reviewee
        ]);
            $cats = $user->getCats();
            return $this->render('user/show.html.twig', [
                'user' => $user,
                'cats' => $cats, 
                'review' => $review,
                'formReview' => $formReview->createView(),
                'reviews' => $reviews,
                'canPostReview' => $canPostReview

            ]);
        
    }



}
