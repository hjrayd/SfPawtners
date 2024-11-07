<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CatRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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


    #[Route('/user/{id}', name: 'show_user')]
    public function show(User $user, CatRepository $catRepository): Response {

         $cats = $user->getCats();


        // foreach($cats as $cat) 
        // {
        //     $catImages =  $cat->getImages()->first();
        // }
           
        
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'cats' => $cats
        ]);
    }

}
