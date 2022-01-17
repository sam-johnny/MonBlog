<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\HTML\Form;
use App\Model\Post;
use App\ObjectHandler;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Validator\PostValidator;

class AdminPostController extends AbstractController
{
    public function new()
    {
        Auth::loginAdmin();

        $errors = [];
        $post = new Post();
        $pdo = Database::getPDO();
        $categoryTable = new CategoryTable($pdo);
        $categories = $categoryTable->list();
        $post->setCreatedAt(date('Y-m-d H:i:s'));

        /* Si des données sont envoyées dans $_POST */
        if (!empty($_POST)) {
            $postTable = new PostTable($pdo);

            /* Verification des champs avec Validator */
            $v = new PostValidator($_POST, $postTable, $post->getID(), $categories);
            ObjectHandler::hydrate($post, $_POST, ['title', 'content', 'slug', 'created_at']);

            /*Si toutes les régles sont correctes*/
            if ($v->validate()) {
                $pdo->beginTransaction();

                /* création de l'article */
                $postTable->createPost($post);

                /* Lié la catégorie à l'article*/
                $postTable->attachCategories($post->getID(), $_POST['categories_ids']);

                $pdo->commit();

                /* Redirection */
                header('Location: ' . "/admin/post/{$post->getID()}?created=1");
                exit();
            } else {
                $errors = $v->errors();
            }
        }

        $form = new Form($post, $errors);
        $this->render('admin/post/new', compact('form', 'categories', 'post'));
    }

    public function edit($params)
    {
        Auth::loginAdmin();

        $pdo = Database::getPDO();
        $postTable = new PostTable($pdo);
        $categoryTable = new CategoryTable($pdo);
        $categories = $categoryTable->list();
        $post = $postTable->find($params['id']);
        $categoryTable->hydratePosts([$post]);
        $success = false;

        $errors = [];

        /* Si des données sont envoyées dans $_POST */
        if (!empty($_POST)) {

            /* Verification des champs avec Validator */
            $validator = new PostValidator($_POST, $postTable, $post->getID(), $categories);
            ObjectHandler::hydrate($post, $_POST, ['title', 'content', 'slug', 'created_at']);

            /*Si toutes les régles sont correctes*/
            if ($validator->validate()) {
                $pdo->beginTransaction();

                /* modification de l'article */
                $postTable->updatePost($post);

                /* Lié la catégorie */
                $postTable->attachCategories($post->getID(), $_POST['categories_ids']);

                $pdo->commit();

                $categoryTable->hydratePosts([$post]);
                $success = true;
            } else {
                $errors = $validator->errors();
            }
        }

        $form = new Form($post, $errors);
        $this->render('admin/post/edit', compact('form', 'success', 'post', 'categories'));
    }

    public function delete($params)
    {
        Auth::loginAdmin();

        $table = new PostTable(Database::getPDO());
        $table->delete($params['id']);

        header('Location: ' . '/admin/posts' . '?delete=1');
    }

    public function index()
    {
        Auth::loginAdmin();

        $title = "Gestion des articles";
        $link = '/admin/posts';
        $posts = (new PostTable(Database::getPDO()))->all();
        $this->render('admin/post/index', compact('title', 'link', 'posts'));
    }

}