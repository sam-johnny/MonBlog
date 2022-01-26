<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\Model\Manager\CategoryManager;
use App\Model\Manager\PostManager;
use App\Model\Manager\UserManager;

class CategoryController extends AbstractController
{
    public function show(array $params)
    {
        Auth::login();

        $id = (int)$params['id'];
        $slug = $params['slug'];
        $pdo = Database::getPDO();
        $category = (new CategoryManager($pdo))->find($id);

        $userManager = new UserManager($pdo);

        /* Si l'utilisateur essaye de rentrer un slug qui n'existe pas cela renvoie à la page actuelle */
        if ($category->getSlug() !== $slug) {
            $url = "/blog/category/{$category->getSlug()}-$id";
            http_response_code(301);
            header('Location: ' . $url);
        }

        $title = $category->getName();

        [$posts, $paginatedQuery, $totalPages] = (new PostManager(Database::getPDO()))->findPaginatedForCategory($category->getID(), 8);

        $link = "/blog/category/{$category->getSlug()}-$id";

        $this->render('category/show', compact('title', 'posts', 'paginatedQuery', 'totalPages', 'link', 'userManager'));
    }
}