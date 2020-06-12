<?php

namespace App\Controller;

use Swift_Message;
use App\Entity\User;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\ContactTType;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="blog_contact")
     */
    public function contact(Request $request, EntityManagerInterface $manager, ContactNotification $notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactTType::class, $contact);

        $form->handleRequest($request);

        $repo = $this->getDoctrine()->getRepository(User::class);
        $donne = $repo->findBy(array('prenom' => 'kenter'));
        dump($donne[0]->getSalt());

        if ($form->isSubmitted() && $form->isValid()) {

            $notification->notify($contact);
            $this->addFlash('success', 'Votre Email a bien été envoyé');    

            $manager->persist($contact); 
            $manager->flush(); 

        }
        
        return $this->render("blog/contact.html.twig", [
            'formContact' => $form->createView()
        ]);
    }
}
