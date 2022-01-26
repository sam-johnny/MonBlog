<?php

namespace App\Controller;


use App\Auth;
use App\Database;
use App\HTML\Form;
use App\Model\Entity\Category;
use App\ObjectHandler;
use App\Model\Manager\CategoryManager;
use App\Validator\CategoryValidator;

class AdminCategoryController extends AbstractController
{
    public function new()
    {
        Auth::loginAdmin();

        $errors = [];
        $category = new Category();

        /*Validation des données rentrées avec Validator*/
        if (!empty($_POST)) {
            $categoryManager = new CategoryManager(Database::getPDO());
            $validator = new CategoryValidator($_POST, $categoryManager);
            ObjectHandler::hydrate($category, $_POST, ['name', 'slug']);
            if ($validator->validate()) {
                $categoryManager->create([
                    'name' => $category->getName(),
                    'slug' => $category->getSlug()
                ]);
                header('Location: ' . "/admin/categories?created=1");
                exit();
            } else {
                $errors = $validator->errors();
            }
        }

        $form = new Form($category, $errors);
        $this->render('admin/category/new', compact('form', 'category'));
    }

    public function edit($params)
    {
        Auth::loginAdmin();

        $categoryManager = new CategoryManager(Database::getPDO());
        $category = $categoryManager->find($params['id']);
        $success = false;
        $errors = [];
        /*Validation des données rentrées avec Validator*/
        if (!empty($_POST)) {
            $validator = new CategoryValidator($_POST, $categoryManager, $category->getID());
            ObjectHandler::hydrate($category, $_POST, ['name', 'slug']);
            if ($validator->validate()) {
                $categoryManager->update([
                    'name' => $category->getName(),
                    'slug' => $category->getSlug()
                ], $category->getID());
                $success = true;
            } else {
                $errors = $validator->errors();
            }
        }

        $form = new Form($category, $errors);
        $this->render('admin/category/edit', compact('form', 'success', 'category'));
    }

    public function delete($params)
    {
        Auth::loginAdmin();

        $categoryManager = new CategoryManager(Database::getPDO());
        $categoryManager->delete($params['id']);
        header('Location: ' . '/admin/categories?delete=1');
    }

    public function index()
    {
        Auth::loginAdmin();

        $title = "Gestion des catégories";
        $link = '/admin/categories';
        $categories = (new CategoryManager(Database::getPDO()))->all();
        $this->render('admin/category/index', compact('title', 'link', 'categories'));
    }


}