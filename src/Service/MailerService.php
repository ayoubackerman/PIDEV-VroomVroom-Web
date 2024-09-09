<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Reservation;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService
{
    
    private $mailer;
    
    
    public function __construct( MailerInterface $mailer)
     {
        
        $this->mailer=$mailer;
     }
    
    public function sendEmail(    $to ): void
    {
        
        $email = (new Email())
            ->from('pidevmycompany2023@gmail.com')
            ->to($to)
            ->subject('Ton reservation est accepte et bien enrigistre')
            ->text('Bonjour Monieur , Votre reservation et accepte !');
             
            $this->mailer->send($email);
      
        // ...
    }
}