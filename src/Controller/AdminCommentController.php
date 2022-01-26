<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\Model\Manager\CommentManager;
use App\Model\Manager\PostManager;
use App\Model\Manager\UserManager;

class AdminCommentController extends AbstractController
{
    /**
     * @throws \App\Security\ForbiddenException
     * @throws \Exception
     */
    public function validate($params)
    {
        Auth::loginAdmin();

        $commentManager = new CommentManager(Database::getPDO());
        $item = $commentManager->find($params['id']);
        $commentManager->update([
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
        $comments = (new CommentManager($pdo))->findCommentsNotValide();
        $postManager = new PostManager($pdo);
        $userManager = new UserManager($pdo);

        $this->render('admin/comment/index', compact('title', 'link', 'comments', 'postManager', 'userManager'));
    }

    /**
     * @throws \App\Security\ForbiddenException
     * @throws \Exception
     */
    public function delete($params)
    {
        Auth::loginAdmin();

        $pdo = Database::getPDO();
        $table = new CommentManager($pdo);
        $table->delete($params['id']);
        header('Location: /admin/comments?delete=1');
    }
}