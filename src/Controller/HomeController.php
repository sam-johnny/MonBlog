<?php

namespace App\Controller;

use App\Auth;
use App\HTML\Form;
use App\Mail\MailContact;
use App\Validator\ContactValidator;
use Valitron\Validator;

class HomeController extends AbstractController
{
    public function show()
    {
        Auth::login();

        $title = "Mon blog - Home";
        $errors = [];

        /*Validation des données rentrées avec Validator*/
        if (!empty($_POST)) {
            Validator::lang('fr');
            $validator = new ContactValidator($_POST);
            $mailContact = new MailContact();
            if ($validator->validate()) {
                /*Variable pour la fonction mail*/
                $mailContact->mailContact($_POST['username'], $_POST['message'], $_POST['email']);
                header('Location: /?send=1');
            } else {
                $errors = $validator->errors();
            }
        }
        $form = new Form($_POST, $errors);

        $this->render('home', compact('form', 'title'));
    }
}