<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\Table\CommentTable;
use App\Table\PostTable;
use App\Table\UserTable;

class AdminCommentController extends AbstractController
{
    public function validate($params)
    {
        Auth::loginAdmin();

        $table = new CommentTable(Database::getPDO());
        $item = $table->find($params['id']);
        $table->update([
            'status' => 1
        ], $item->getID());
        header('Location: /admin/comments?validated=1');
    }

    public function index()
    {
        Auth::loginAdmin();

        $title = "Gestion des commentaires";
        $link = '/admin/comments';
        $pdo = Database::getPDO();
        $comments = (new CommentTable($pdo))->findCommentsNotValide();
        $postTable = new PostTable($pdo);
        $userTable = new UserTable($pdo);

        $this->render('admin/comment/index', compact('title', 'link', 'comments', 'postTable', 'userTable'));
    }

    public function delete($params)
    {
        Auth::loginAdmin();

        $pdo = Database::getPDO();
        $table = new CommentTable($pdo);
        $table->delete($params['id']);
        header('Location: /admin/comments?delete=1');
    }
}