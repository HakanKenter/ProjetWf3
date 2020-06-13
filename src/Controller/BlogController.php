<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Form\Annonce2Type;
// use App\Form\IdentificationType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    
      /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blogEdit")
     */
    public function formulaire(Annonce $annonce = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$annonce)
        {
            $annonce = new Annonce();
        }
        
        $form = $this->createForm(Annonce2Type::class, $annonce);
                                                     
        $form->handleRequest($request);

        // dump($annonce);
         

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$annonce->getId()) 
            {
                 $annonce->setCreatedAt(new \DateTime());
            }
           

            $manager->persist($annonce);
            $manager->flush();
            return $this->redirectToRoute('blog_show', ['id' => $annonce->getId()]);
        }
        // dump($annonce);
        return $this->render('blog/depot_annonce.html.twig',[
            'formAnnonce' => $form->createView(),
            'editMode' => $annonce->getId()!== null
        ]);
    }



    


    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show($id) 
    {
        $repo = $this->getDoctrine()->getRepository(Annonce::class);

         $annonce = $repo->find($id);

        // return $this->render('blog/show.html.twig');
        return $this->render('blog/show.html.twig',['annonce'=> $annonce ]);
    }






    /**
     * @Route("/", name="blog")
     */
    public function index()
    {                                  // LE REPOSITORIE(getRepository) PERMET DE SELECTIONNER DES DONNEES DANS LA TABLLE
         $repo = $this-> getDoctrine()->getRepository(Annonce::class);  //permet d'aller chercher tous les annonces

        $annonces = $repo->findAll();  // la variable annonces est un array et on va le passer à twig
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'annonces' => $annonces,
            'title' => "Bonjour et bienvenue sur notre site internet !"
        ]);
    }

    // /**
    //  * @Route("/", name="home")
    //  */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'title' => "Bonjour et bienvenue sur notre site internet !"
        ]);
    }

    /**
     * @Route("/blog/compte", name="compte")
     */
    public function compte()
    {
        $identification = new User;

        $form = $this->createForm(IdentificationType::class, $identification);

        return $this->render('blog/compte.html.twig', [
            'formIdentification' => $form->createView() 
        ]);
    }

    // /**
    //  * @Route("/blog/create", name="create")
    //  */
    // public function form()
    // {
    //     $annonce = new Annonce;

    //     $form = $this->createForm(AnnonceFormType::class, $annonce);

    //     return $this->render('blog/create.html.twig', [
    //         'formAnnonce' => $form->createView()
    //     ]);
    // }

    /**
     * @Route("/blog/{id}", name="annonce_personnel")
     */
    public function annoncePersonnel(User $user)
    {
        return $this->render('blog/annoncePersonnel.html.twig', [
            'user' => $user
        ]);
    }
}
