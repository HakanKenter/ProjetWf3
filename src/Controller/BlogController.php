<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Form\AnnonceFormType;
use App\Form\IdentificationType;
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
     * @Route("/blog", name="blog")
     * @Route("", name="blog")
     */
    public function index(AnnonceRepository $repo)
    {
        $annonce = $repo->findAll();

        dump($annonce);

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'annonce' => $annonce,
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
     * @Route("/blog/{id}", name="annonce_personnel")
     */
    public function annoncePersonnel(User $user)
    {
        return $this->render('blog/annoncePersonnel.html.twig', [
            'user' => $user
        ]);
    }
}
