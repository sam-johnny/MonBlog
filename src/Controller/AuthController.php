<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\HTML\Form;
use App\Model\User;
use App\ObjectHandler;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;
use App\Validator\UserRegisterValidator;
use App\Validator\UserValidator;

class AuthController extends AbstractController
{
    public function login()
    {
        Auth::login();

        $user = new User();
        $errors = [];
        if (!empty($_POST)) {
            $user->setUsername($_POST['username']);
            $errors['password'] = 'Identifiant ou mot de passe incorrect';

            if (!empty($_POST['username']) || !empty($_POST['password'])) {
                $table = new UserTable(Database::getPDO());
                try {
                    $username = $table->findByUsername($_POST['username']);
                    if (password_verify($_POST['password'], $username->getPassword()) === true) {
                        $_SESSION['auth'] = [
                            'id' => $username->getId(),
                            'username' => $username->getUsername(),
                            'password' => $username->getPassword(),
                            'email' => $username->getEmail(),
                            'role' => $username->getRole(),
                        ];
                        header('Location: ' . '/');
                        exit();
                    }
                } catch (NotFoundException $e) {

                }
            }

        }

        $form = new Form($user, $errors);

        $this->render('auth/login', compact('form'));
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }

    public function register()
    {
        $errors = [];
        $user = new User();

        if (!empty($_POST)) {
            $userTable = new UserTable(Database::getPDO());
            /*Validation des données rentrées avec Validator*/
            $validator = new UserRegisterValidator($_POST, $userTable, $user->getID());
            ObjectHandler::hydrate($user, $_POST, ['username', 'password', 'email']);
            if ($validator->validate()) {
                $userTable->createUser($user);
                header('Location: /login?register=1');
                exit();
            } else {
                $errors = $validator->errors();
            }
        }
        $form = new Form($user, $errors);
        $this->render('auth/register', compact('form'));
    }
}