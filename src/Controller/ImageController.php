<?php
namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImageController extends AbstractController
{
    #[Route('/image/new', name: 'app_image_new')]
    public function new(
        Request $request,
        SluggerInterface $slugger,
        #[Autowire('%pictures_directory%')] string $picturesDirectory,
        EntityManagerInterface $entityManager
    ): Response
    {
        $form = $this->createForm(ImageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('picture')->getData();

            //On récupère le chat concerné
            $catPicture = $form->get('cat')->getData();

            // On vérifie que les images ont bien été uploadé
            if (!empty($pictures) && is_array($pictures)) {
                foreach ($pictures as $picture) {
                    if ($picture) {

                        //nouvelle instance pour chaque image uploadé
                        $image = new Image();

                        if($catPicture) {
                        //On utilise le nom du chat pour créer l'alt de chaque image
                        $image->setImageAlt($catPicture->getName());
                        } else {
                            $this->addFlash('error', 'Veuillez sélectionner un chat.');
                            return $this->redirectToRoute('app_image_new'); 
                        }
                        //on attribue l'image au chat séléctionné dans notre formulaire
                        $image->setCat($form->get('cat')->getData());

                        // Renomme le fichier pour éviter les conflits
                        $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeFilename = $slugger->slug($originalFilename);
                        $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();

                        try {
                            // on déplace le fichier dans le dossier spécifié
                            $picture->move($picturesDirectory, $newFilename);
                        } catch (FileException $e) {

                            //si l'on rencontre une erreur lors de l'upload des fichiers une erreur s'affiche
                            $this->addFlash('error', 'Erreur lors de l\'upload de l\'image : ' . $e->getMessage());

                            //si il y a une erreur, on est redirigé vers la page du formulaire
                            return $this->redirectToRoute('app_image_new');
                        }

                        // On définit le chemin de l'image
                        $image->setImageLink('/uploads/pictures/' . $newFilename);

                        
                        $entityManager->persist($image);
                    } else {
                        $this->addFlash('error', 'Le fichier uploadé n\'est pas valide.');
                        return $this->redirectToRoute('app_image_new');
                    }
                }
                //on envoie les données dans la BDD
                $entityManager->flush();

                // Si tout à fonctionné on est redirigé versla page "home" 
                return $this->redirectToRoute('app_home');
            } else {
                // si aucune image n'a été séléctionné 
                $this->addFlash('error', 'Aucune image n\'a été sélectionnée pour l\'upload.');
            }
        }

        return $this->render('image/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
