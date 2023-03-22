<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('tisch1@menukarte.com')
            ->to('kellner@menukarte.com')
            ->subject('Bestellung')
            ->text('extra Pommes');

        $mailer->send($email);

        return new Response('email versendet');

    }
}
