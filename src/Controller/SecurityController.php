<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\IdentificationType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    // /**
    //  * @Route("/security", name="security")
    //  */
    // public function index()
    // {
    //     return $this->render('security/index.html.twig', [
    //         'controller_name' => 'SecurityController',
    //     ]);
    // }

    /**
     * @Route("/registration", name="registration")
     */
    public function registration()
    {
        $user = new User;

        $form = $this->createForm(IdentificationType::class, $user);

        return $this->render("security/registration.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
