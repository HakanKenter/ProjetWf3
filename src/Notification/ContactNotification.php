<?php

namespace App\Notification;

use App\Entity\User;
use Twig\Environment;
use App\Entity\Contact;

class ContactNotification
{
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

    public function notify(User $user)
    {
        $message = (new \Swift_Message('Message : Féliciation ! Vous êtes inscrit !'))
            ->setFrom('hakan.kt@outlook.fr')
            ->setTo($user->getEmail())
            ->setReplyTo($user->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig', [
                'contact' => $user
            ]), 'text/html');
        $this->mailer->send($message);
    }
}
