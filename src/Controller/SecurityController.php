<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\IdentificationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, AuthenticationUtils $authenticationUtils, ContactNotification $notification)
    {
        $user = new User;

        $form = $this->createForm(IdentificationType::class, $user); 

        dump($request);

        $form->handleRequest($request);
        $user->setRoles(['ROLE_USER']);
        $error = $authenticationUtils->getLastAuthenticationError();


        if($form->isSubmitted() && $form->isValid())
        {
            $notification->notify($user);
            $this->addFlash('successs', 'Votre Email a bien été envoyé');
            $user->setCreatedAt(new \DateTime());
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash); 
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Félicitation ! Vous êtes maintenant inscrit !');
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'formIdentification' => $form->createView(),
            'error' => $error,
            'errorAge' => "Vous devez avoir au moin 18 ans pour vous inscrire"
        ]);
    }

    /**
     * @Route("/blog/{id}/profil", name="modifierProfil")
     */
    public function registrations(User $user = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, AuthenticationUtils $authenticationUtils)
    {
        if(!$user)
        {
            $user = new User;
        }

        $form = $this->createForm(IdentificationType::class, $user); 

        $user->setRoles(['ROLE_USER']);
        $form->handleRequest($request);
        $user->setRoles(['ROLE_USER']);

        // $error = $authenticationUtils->getLastAuthenticationError();


        if($form->isSubmitted() && $form->isValid())
        {
            // if(!$user->getId())
            // {
            //     $user->setCreatedAt(new \DateTime);
            // }

            $user->setCreatedAt(new \DateTime());

            $hash = $encoder->encodePassword($user, $user->getPassword());


            $user->setPassword($hash); 

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Vos modifications ont été enregistrées avec succès !');
        
        }

        return $this->render('security/information_personnel.html.twig',[
            'formDonneePersonnel' => $form->createView(),
            'editMode' => $user->getId()!== null
        ]);
    }

    /**

     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response 
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
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