<?php

namespace App\Controller;


use App\Auth;
use App\Database;
use App\HTML\Form;
use App\Model\Category;
use App\ObjectHandler;
use App\Table\CategoryTable;
use App\Validator\CategoryValidator;

class AdminCategoryController extends AbstractController
{
    public function new()
    {
        Auth::loginAdmin();

        $errors = [];
        $category = new Category();

        if (!empty($_POST)) {
            $categoryTable = new CategoryTable(Database::getPDO());
            /*Validation des données rentrées avec Validator*/
            $validator = new CategoryValidator($_POST, $categoryTable);
            ObjectHandler::hydrate($category, $_POST, ['name', 'slug']);
            if ($validator->validate()) {
                $categoryTable->create([
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

        $categoryTable = new CategoryTable(Database::getPDO());
        $category = $categoryTable->find($params['id']);
        $success = false;
        $errors = [];
        /*Validation des données rentrées avec Validator*/
        if (!empty($_POST)) {
            $validator = new CategoryValidator($_POST, $categoryTable, $category->getID());
            ObjectHandler::hydrate($category, $_POST, ['name', 'slug']);
            if ($validator->validate()) {
                $categoryTable->update([
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

        $table = new CategoryTable(Database::getPDO());
        $table->delete($params['id']);
        header('Location: ' . '/admin/categories?delete=1');
    }

    public function index()
    {
        Auth::loginAdmin();

        $title = "Gestion des catégories";
        $link = '/admin/categories';
        $categories = (new CategoryTable(Database::getPDO()))->all();
        $this->render('admin/category/index', compact('title', 'link', 'categories'));
    }


}