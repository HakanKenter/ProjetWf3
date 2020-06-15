<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Category;
use App\Form\Annonce2Type;
use App\Form\AnnonceFormType;

// use App\Form\IdentificationType;
use App\Form\IdentificationType;
use App\Form\DonneePersonnelType;
use App\Repository\UserRepository;
use App\Form\SelectionCategoryType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BlogController extends AbstractController
{
    
     /**
     * @Route("blog/new", name="blog_create")
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
        $id = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository(User::class);
        $userSS = $repo->find($id);

        // $user->setPrenom($userSS);
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
                $user = new User;
                $annonce->setCreatedAt(new \DateTime());
                $annonce->setUser($userSS);
                // $post = $this->getDoctrine()->getRepository(UserRepository::class)->find($id);
                // $this->$annonce->setUser(1);
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
         $id_user = $repo->find($id)->getUser();

        $reponse = $this->getDoctrine()->getRepository(User::class);
         $user = $reponse->find($id_user);
         dump($user);

        // return $this->render('blog/show.html.twig');
        return $this->render('blog/show.html.twig',['annonce'=> $annonce,'user'=> $user]);
    }
    

    /**
     * @Route("/", name="blog")
     * @Route("", name="blog")
     */
    public function index(Request $request)
    {                      
        $annonce = new Annonce;

        $form = $this->createForm(SelectionCategoryType::class, $annonce);
        $form->handleRequest($request);
        $categories = [ 'id' => null ];
        $repo = $this-> getDoctrine()->getRepository(Annonce::class);  //permet d'aller chercher tous les annonces
        $annonces = $repo->findAll();  // la variable annonces est un array et on va le passer à twig

        if($form->isSubmitted() && $form->isValid())
        {
            $categories = $annonce->getCategory();
        }
 
        return $this->render('blog/index.html.twig', [
            'formCategory' => $form->createView(),
            'controller_name' => 'BlogController',
            'annonces' => $annonces,
            'categories' => $categories,
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
