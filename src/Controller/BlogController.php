<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Form\AnnonceFormType;
// use App\Form\IdentificationType;
use App\Repository\AnnonceRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
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

    // /**
    //  * @Route("/blog/compte", name="compte")
    //  */
    // public function compte()
    // {
    //     $identification = new User;

    //     $form = $this->createForm(IdentificationType::class, $identification);

    //     return $this->render('blog/compte.html.twig', [
    //         'formIdentification' => $form->createView() 
    //     ]);
    // }

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

}
