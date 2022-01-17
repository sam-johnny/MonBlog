<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\HTML\Form;
use App\Model\Comment;
use App\ObjectHandler;
use App\Table\CategoryTable;
use App\Table\CommentTable;
use App\Table\PostTable;
use App\Validator\CommentValidator;
use Valitron\Validator;

class PostController extends AbstractController
{


    public function blog()
    {
        Auth::login();

        $title = 'Mon Blog';

        $postTable = new PostTable(Database::getPDO());
        [$posts, $paginatedQuery, $totalPages] = $postTable->findPaginated(6);

        $link = "/blog";

        $this->render('post/blog', compact('title', 'posts', 'paginatedQuery', 'totalPages', 'link'));
    }

    public function show(array $params)
    {
        Auth::login();

        $id = (int)$params['id'];
        $slug = $params['slug'];

        $pdo = Database::getPDO();

        /*Récupération des articles*/
        $post = (new PostTable($pdo))->find($id);
        (new CategoryTable($pdo))->hydratePosts([$post]);

        /*Récupération des commentaires*/
        $commentTable = new CommentTable($pdo);
        $comments = $commentTable->findComments($id);
        $comment = new Comment();
        $comment->setCreatedAt(date('Y-m-d H:i:s'));

        $errors = [];
        /* Verification des champs avec Validator */
        if (!empty($_POST)) {
            Validator::lang('fr');
            $validator = new CommentValidator($_POST);
            ObjectHandler::hydrate($comment, $_POST, ['content']);
            if ($validator->validate()) {
                $commentTable->create([
                    'username' => $_SESSION['auth']['username'],
                    'email' => $_SESSION['auth']['email'],
                    'content' => $comment->getContent(),
                    'post_id' => $post->getID(),
                    'created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
                    'status' => 0
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
        $this->render('post/show', compact('comments', 'form', 'post'));
    }
}