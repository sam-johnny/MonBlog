<?php

namespace App\Mail;

class MailContact
{

    /**
     * Paramètre de la fonction mail
     *
     * @param $postUsername
     * @param $postMessage
     * @param $postEmail
     */
    public function mailContact($postUsername, $postMessage, $postEmail): void
    {
        $to = 'sam.johnny1608@gmail.com';
        $subject = 'Formulaire de contact de ' . $postUsername;
        $message = str_replace("\n.", "\n..", $postMessage);
        $headers = 'FROM: ' . $postEmail;

        mail($to, $subject, $message, $headers);
    }

}