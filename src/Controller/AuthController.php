<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\HTML\Form;
use App\Model\Entity\User;
use App\ObjectHandler;
use App\Exception\NotFoundException;
use App\Model\Manager\UserManager;
use App\Validator\UserRegisterValidator;

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
                $userManager = new UserManager(Database::getPDO());
                try {
                    $username = $userManager->findByUsername($_POST['username']);
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

    /**
     * @throws \Exception
     */
    public function register()
    {
        $errors = [];
        $user = new User();

        if (!empty($_POST)) {
            $userManager = new UserManager(Database::getPDO());
            /*Validation des données rentrées avec Validator*/
            $validator = new UserRegisterValidator($_POST, $userManager, $user->getID());
            ObjectHandler::hydrate($user, $_POST, ['username', 'password', 'email']);
            if ($validator->validate()) {
                $userManager->createUser($user);
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