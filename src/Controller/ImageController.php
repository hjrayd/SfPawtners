<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function index(): Response
    {
        return $this->render('image/index.html.twig', [
            'controller_name' => 'ImageController',
        ]);
    }

    #[Route('/image/new', name: 'app_image_new')]
    public function new(
        Request $request,
        SluggerInterface $slugger,
        #[Autowire('%pictures_directory%')] string $picturesDirectory,
        EntityManagerInterface $entityManager
    ): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $picture */

            //on récupère l'image qui a été uplaod depuis notre formulaire
            $picture = $form->get('picture')->getData();
            if ($picture) {

                //on renomme le nom du fichier pour eviter les confusions
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();

                try {
                    //on stocke les images dans un fichier "uplaod"
                    $picture->move($picturesDirectory, $newFilename);
                } catch (FileException $e) {
                    //on gère ici les problèmes d'affichages
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image');
                    return $this->redirectToRoute('app_image_new');
                }
                
                $image->setImageLink('/uploads/pictures/' . $newFilename);
            }
                
                $entityManager->persist($image);
                $entityManager->flush();
                
                return $this->redirectToRoute('app_home');
        }
        return $this->render('image/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}


