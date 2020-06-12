<?php

namespace App\Controller;

use App\Form\ContactType;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            // Ici nous enverrons le mail
            $message = (new Swift_Message('Nouveau Contact'))
                // On attribute l'expediteur
                ->setFrom($contact['email'])

                // On attribut le destinataire
                ->setTo('votre@adresse.fr')

                //On crée le message avec la vue twig
                ->setBody(
                    $this->renderView(
                        'email/contact.html.twig', compact('contact')
                    ),
                    'text/html'
                )
            ;
            // dd($contact);
            $mailer->send($message);
            
            $this->addFlash('message', 'Le message à bien été envoyé');
            //Cette ligne renvoi un message
            // return $this->redirectToRoute('security_login');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' =>  $form->createView()
        ]);
    }
}
