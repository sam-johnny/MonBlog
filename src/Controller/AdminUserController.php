<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\HTML\Form;
use App\ObjectHandler;
use App\Table\UserTable;
use App\Validator\UserUpdateValidator;
class AdminUserController extends AbstractController
{
    public function index()
    {
        Auth::loginAdmin();

        $title = "Gestion des rôles";
        $link = '/admin/users';
        $users = (new UserTable(Database::getPDO()))->all();
        $this->render('admin/user/index', compact('title', 'link', 'users'));
    }

    public function edit($params)
    {
        Auth::loginAdmin();

        $userTable = new UserTable(Database::getPDO());
        $user = $userTable->find($params['id']);
        $success = false;
        $errors = [];

        if (!empty($_POST)) {
            /*Validation des données rentrées avec Validator*/
            $validator = new UserUpdateValidator($_POST, $userTable, $user->getID());
            ObjectHandler::hydrate($user, $_POST, ['username', 'email' , 'role']);
            if ($validator->validate()) {
                $userTable->update([
                    'username' => $user->getUsername(),
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
}