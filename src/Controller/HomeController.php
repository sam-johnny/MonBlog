<?php

namespace App\Controller;

use App\Auth;
use App\HTML\Form;
use App\Validator\ContactValidator;
use Valitron\Validator;

class HomeController extends AbstractController
{
    public function show()
    {
        Auth::login();

        $title = "Mon blog - Home";
        $errors = [];

        if (!empty($_POST)) {
            /*Validation des données rentrées avec Validator*/
            Validator::lang('fr');
            $validator = new ContactValidator($_POST);
            if ($validator->validate()) {
                /*Variable pour la fonction mail*/
                $to = 'sam.johnny1608@gmail.com';
                $subject = 'Formulaire de contact de ' . $_POST['username'];
                $message = str_replace("\n.", "\n..", $_POST['message']);
                $headers = 'FROM: ' . $_POST['email'];

                mail($to, $subject, $message, $headers);
                header('Location: /?send=1');
            } else {
                $errors = $validator->errors();
            }
        }
        $form = new Form($_POST, $errors);

        $this->render('home', compact('form', 'title'));
    }
}