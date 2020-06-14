<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Form\AnnonceFormType;
use App\Form\IdentificationType;
use App\Form\Annonce2Type;

// use App\Form\IdentificationType;
use App\Form\DonneePersonnelType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BlogController extends AbstractController
{
    
     /**
     * @Route("/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blogEdit")
     */
    public function formulaire(Annonce $annonce = null, Request $request, EntityManagerInterface $manager)
    {
        // $user = new User;
        
        if(!$annonce)
        {
            $annonce = new Annonce();
        }
        // $user =  new User;
        $userSS = $this->getUser()->getPrenom();
        // $util= $annonce->setUser($userSS);
        // $form = $this->createFormBuilder($annonce)
        //              ->add('title')
        //              ->add('Prix')
        //              ->add('Image')
        //              ->add('user')
        //              ->getForm();

        
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

        return $this->render('blog/depot_annonce.html.twig',[

        // dump($annonce);
        // return $this->render('blog/annonce.html.twig',[

            'formAnnonce' => $form->createView(),
            'editMode' => $annonce->getId()!== null,
            'userSS' => $userSS
        ]);
    }


 

     /**
     * @Route("/blog/{id}/delete", name="delete")
     */
    public function delete(Annonce $annonce)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute('blog');
    }
    


    /**
     * @Route("/blog/{id}/show", name="blog_show")
     */
    public function show($id) 
    {
        $repo = $this->getDoctrine()->getRepository(Annonce::class);

         $annonce = $repo->find($id);

        // return $this->render('blog/show.html.twig');
        return $this->render('blog/show.html.twig',['annonce'=> $annonce]);
    }
    


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

    /**
     * @Route("/blog/create", name="create")
     */
    public function form()
    {
        $annonce = new Annonce;

        $form = $this->createForm(AnnonceFormType::class, $annonce);

        return $this->render('blog/create.html.twig', [
            'formAnnonce' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/{id}/perso", name="annonce_personnel")
     */
    public function annoncePersonnel(User $user)
    {
        return $this->render('blog/annoncePersonnel.html.twig', [
            'user' => $user
        ]);
    }
}
