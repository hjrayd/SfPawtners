<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;


class SendEmailService 
{
    public function __construct(private MailerInterface $mailer)
    {
       
    }

    public function send(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context
    ): void //La fonction ne retourne rien donc -> void
    {
        //Création du mail
        $email = (new TemplatedEmail()) //Cette classe permet de rajouter les informations nécessaire à l\'envoie du mail (expediteur, destinaire)
        ->from($from)
        ->to($to)
        ->subject($subject)
        ->htmlTemplate("email/$template.html.twig")
        ->context($context);

        //Envoie du mail
        $this->mailer->send($email);
        
    }
}

?>