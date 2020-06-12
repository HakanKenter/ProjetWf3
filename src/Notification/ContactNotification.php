<?php

namespace App\Notification;

use App\Entity\User;
use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ContactNotification extends AbstractController
{
    // use Ttest;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Message : Voici le message' ))
            ->setFrom("hakan782@hotmail.fr")
            ->setTo($contact->getEmail())
            ->setReplyTo("hakan782@hotmail.fr")
            ->setBody($this->renderer->render('emails/contact.html.twig', [
                'contact' => $contact,
            ]), 'text/html');
        $this->mailer->send($message);
    }

    public function createBodyMail($view, array $parameters)
    {
        return $this->engine->render($view, $parameters);
    }
}
