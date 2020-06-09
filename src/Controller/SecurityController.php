<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\IdentificationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, AuthenticationUtils $authenticationUtils)
    {
        $user = new User;

        $form = $this->createForm(IdentificationType::class, $user); 

        dump($request);

        $form->handleRequest($request);

        $error = $authenticationUtils->getLastAuthenticationError();


        if($form->isSubmitted() && $form->isValid())
        {

            $user->setCreatedAt(new \DateTime());

            $hash = $encoder->encodePassword($user, $user->getPassword());


            $user->setPassword($hash); 

            $manager->persist($user);
            $manager->flush();

            // return $this->redirectToRoute('security_login'); // On redirige vers ma page de connexion après inscription
        }

        return $this->render('security/registration.html.twig', [
            'formIdentification' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("registration/cgv", name="CGV")
     */
    public function cgv()
    {
        return $this->render('security/cgv.html.twig');
    }

    /**
     * @Route("registration/cgu", name="CGU")
     */
    public function cgu()
    {
        return $this->render('security/cgu.html.twig');
    }

    /**
     * @Route("registration/politique", name="politique_de_confidentialite")
     */
    public function politique_confidentialite()
    {
        return $this->render('security/politiqueConfidentialite.html.twig');
    }
}
