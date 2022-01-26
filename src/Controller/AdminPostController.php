<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\HTML\Form;
use App\Model\Entity\Post;
use App\ObjectHandler;
use App\Model\Manager\CategoryManager;
use App\Model\Manager\PostManager;
use App\Model\Manager\UserManager;
use App\Validator\PostValidator;

class AdminPostController extends AbstractController
{
    public function new()
    {
        Auth::loginAdmin();

        $errors = [];
        $post = new Post();
        $pdo = Database::getPDO();
        $categoryManager = new CategoryManager($pdo);
        $userManager = new UserManager($pdo);
        $categories = $categoryManager->list();
        $users = $userManager->all();

        $post->setCreatedAt(date('Y-m-d H:i:s'));

        /* Si des données sont envoyées dans $_POST */
        if (!empty($_POST)) {
            $postManager = new PostManager($pdo);

            /* Verification des champs avec Validator */
            $v = new PostValidator($_POST, $postManager, $post->getID(), $categories);
            ObjectHandler::hydrate($post, $_POST, ['title', 'chapo','content', 'slug']);

            /*Si toutes les régles sont correctes*/
            if ($v->validate()) {
                $pdo->beginTransaction();

                /* création de l'article */
                $postManager->createPost($post);

                /* Lié la catégorie à l'article*/
                $postManager->attachCategories($post->getID(), $_POST['categories_ids']);

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
        $postManager = new PostManager($pdo);
        $categoryManager = new CategoryManager($pdo);
        $categories = $categoryManager->list();
        $post = $postManager->find($params['id']);
        $categoryManager->hydratePosts([$post]);
        $success = false;

        $errors = [];


        if (!empty($_POST)) {
            $validator = new PostValidator($_POST, $postManager, $post->getID(), $categories);
            ObjectHandler::hydrate($post, $_POST, ['title', 'content', 'slug']);

            if ($validator->validate()) {
                $pdo->beginTransaction();
                $postManager->updatePost($post);
                $postManager->attachCategories($post->getID(), $_POST['categories_ids']);
                $pdo->commit();
                $categoryManager->hydratePosts([$post]);
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

        $postManager = new PostManager(Database::getPDO());
        $postManager->delete($params['id']);

        header('Location: ' . '/admin/posts' . '?delete=1');
    }

    public function index()
    {
        Auth::loginAdmin();

        $title = "Gestion des articles";
        $link = '/admin/posts';
        $posts = (new PostManager(Database::getPDO()))->all();
        $this->render('admin/post/index', compact('title', 'link', 'posts'));
    }

}