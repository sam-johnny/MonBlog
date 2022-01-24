<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 10/01/2022
 * Time: 18:00
 */

namespace App\Controller;

use App\Auth;
use App\HTML\Form;
use App\Mail\MailContact;
use App\Validator\ContactValidator;
use Valitron\Validator;

class ContactController extends AbstractController
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
            $mailContact = new MailContact();
            if ($validator->validate()) {
                $mailContact->mailContact($_POST['username'], $_POST['message'], $_POST['email']);
                header('Location: /contact?send=1');
                exit();
            } else {
                $errors = $validator->errors();
            }
        }
        $form = new Form($_POST, $errors);

        $this->render('contact', compact('form', 'title'));
    }
}