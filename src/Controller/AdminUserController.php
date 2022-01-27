<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\HTML\Form;
use App\ObjectHandler;
use App\Model\Manager\UserManager;
use App\Validator\UserUpdateValidator;
class AdminUserController extends AbstractController
{
    public function index()
    {
        Auth::loginAdmin();

        $title = "Gestion des rôles";
        $link = '/admin/users';
        $users = (new UserManager(Database::getPDO()))->all();
        $this->render('admin/user/index', compact('title', 'link', 'users'));
    }

    public function edit($params)
    {
        Auth::loginAdmin();

        $userManager = new UserManager(Database::getPDO());
        $user = $userManager->find($params['id']);
        $success = false;
        $errors = [];

        if (!empty($_POST)) {
            /*Validation des données rentrées avec Validator*/
            $validator = new UserUpdateValidator($_POST, $userManager, $user->getID());
            ObjectHandler::hydrate($user, $_POST, ['username', 'email' , 'role']);
            if ($validator->validate()) {
                $userManager->update([
                    'username' => $user->getUsername(),
                    'password' => password_hash($user->getPassword(), PASSWORD_BCRYPT),
                    'email' => $user->getEmail(),
                    'role' => $user->getRole()
                ], $user->getID());
                $success = true;
            } else {
                $errors = $validator->errors();
            }
        }

        $form = new Form($user, $errors);
        $this->render('admin/user/edit', compact('success', 'form', 'user'));
    }

    public function delete($params)
    {
        Auth::loginAdmin();

        $userManager = new UserManager(Database::getPDO());
        $userManager->delete($params['id']);
        header('Location: ' . '/admin/users?delete=1');
    }


}