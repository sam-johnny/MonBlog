<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\HTML\Form;
use App\Model\Entity\Comment;
use App\ObjectHandler;
use App\Model\Manager\CategoryManager;
use App\Model\Manager\CommentManager;
use App\Model\Manager\PostManager;
use App\Model\Manager\UserManager;
use App\Validator\CommentValidator;
use Valitron\Validator;

class PostController extends AbstractController
{


    public function blog()
    {
        Auth::login();

        $title = 'Mon Blog';
        $pdo = Database::getPDO();

        $postManager = new PostManager($pdo);
        $userManager = new UserManager($pdo);
        [$posts, $paginatedQuery, $totalPages] = $postManager->findPaginated(6);

        $link = "/blog";

        $this->render('post/blog', compact('title', 'posts', 'paginatedQuery', 'totalPages', 'link', 'userManager'));
    }

    public function show(array $params)
    {
        Auth::login();

        $id = (int)$params['id'];
        $slug = $params['slug'];

        $pdo = Database::getPDO();

        /*Récupération des articles*/
        $post = (new PostManager($pdo))->find($id);
        (new CategoryManager($pdo))->hydratePosts([$post]);

        $userManager = new UserManager($pdo);
        $user = $userManager->find($post->getUserID());

        /*Récupération des commentaires*/
        $commentManager = new CommentManager($pdo);
        $comments = $commentManager->findComments($id);
        $comment = new Comment();
        $comment->setCreatedAt(date('Y-m-d H:i:s'));

        $errors = [];
        /* Création commentaire, verification des champs avec Validator */
        if (!empty($_POST)) {
            Validator::lang('fr');
            $validator = new CommentValidator($_POST);
            ObjectHandler::hydrate($comment, $_POST, ['content']);
            if ($validator->validate()) {
                $commentManager->create([
                    'content' => $comment->getContent(),
                    'post_id' => $post->getID(),
                    'created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
                    'status' => 0,
                    'user_id' => $_SESSION['auth']['id']
                ]);
                header('Location: ' . "/blog/{$post->getSlug()}-{$id}" . '?commented=1');
                exit();
            } else {
                $errors = $validator->errors();
            }
        }

        if ($post->getSlug() !== $slug) {
            $url = "/blog/{$post->getSlug()}-{$id}";
            http_response_code('301');
            header('Location: ' . $url);
        }

        $form = new Form($comment, $errors);
        $this->render('post/show', compact('comments', 'form', 'post', 'user', 'userManager'));
    }
}