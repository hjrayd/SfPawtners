<?php

namespace App\Controller;

use App\Form\UserFilterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $userRepository, Request $request, PaginatorInterface $paginatorInterface): Response
    {
        $userLogin = $this->getUser();
        if(!$userLogin) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }
        
        $form = $this->createForm(UserFilterType::class);

        $form->handleRequest($request);

        $data = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            $pseudo = $filters['pseudo'];

            $data = $userRepository->findUserPseudo($pseudo);
        } else {
            $data = $userRepository->findBy([], ["registerDate" => "DESC"]);
        }

          //Pagination des users à l'aide de KNB Paginator
        $users = $paginatorInterface->paginate
        (
        $data,
        $request->query->getInt('page', 1),
          16 //On affiche 12 users par pages
        );

        return $this->render('admin/index.html.twig', [
            'data' => $data,
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/ban/{id}', name: 'ban_admin')]
    public function ban(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $userLogin = $this->getUser();
        if(!$userLogin) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $roles = $userLogin->getRoles();

        $user = $userRepository->find($id);

        if(!$user) {
            $this->addFlash('message', 'Utilisateur introuvable');
            return $this->redirectToRoute('app_admin');
        }

        if (in_array("ROLE_ADMIN", $roles)) {
        $user->setBan(true);
        $entityManager->flush();

        $this->addFlash('message', 'L\'utilisateur à bien été banni');
        return $this->redirectToRoute('app_admin');
        } else {
            $this->addFlash('message', 'Vous n\'avez pas l\'autorisation d\effectuer cette action.');
            return $this->redirectToRoute('app_cat');
        }


    }

    #[Route('/admin/unban/{id}', name: 'unban_admin')]
    public function unban(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $userLogin = $this->getUser();
        if(!$userLogin) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $roles = $userLogin->getRoles();
        
        $user = $userRepository->find($id);

        if(!$user) {
            $this->addFlash('message', 'Utilisateur introuvable');
            return $this->redirectToRoute('app_admin');
        }

        if (in_array("ROLE_ADMIN", $roles)) {
        $user->setBan(false);
        $entityManager->flush();

        $this->addFlash('message', 'L\'utilisateur à bien été débanni');
        return $this->redirectToRoute('app_admin');
        } else {
            $this->addFlash('message', 'Vous n\'avez pas l\'autorisation d\'effectuer cette action.');
            return $this->redirectToRoute('app_cat');
        }

    }






}
