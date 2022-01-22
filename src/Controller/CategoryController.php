<?php

namespace App\Controller;

use App\Auth;
use App\Database;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Table\UserTable;

class CategoryController extends AbstractController
{
    public function show(array $params)
    {
        Auth::login();

        /* Récupération de l'id via la fonction 'match' d'altorouter */
        $id = (int)$params['id'];
        /* Récupération du slug via la fonction 'match' d'altorouter */
        $slug = $params['slug'];
        $pdo = Database::getPDO();
        /* Récupération de la catégories via l'id de la catégorie */
        $category = (new CategoryTable($pdo))->find($id);

        $userTable = new UserTable($pdo);

        /* Si l'utilisateur essaye de rentrer un slug qui n'existe pas cela renvoie à la page actuelle */
        if ($category->getSlug() !== $slug) {
            $url = "/blog/category/{$category->getSlug()}-$id";
            /*Redirection permanente*/
            http_response_code(301);
            header('Location: ' . $url);
        }

        /* Le titre de la page */
        $title = $category->getName();

        /* Récupere les articles avec la limite de la pagination */
        [$posts, $paginatedQuery, $totalPages] = (new PostTable(Database::getPDO()))->findPaginatedForCategory($category->getID(), 8);

        /* Lien pour la pagination */
        $link = "/blog/category/{$category->getSlug()}-$id";

        $this->render('category/show', compact('title', 'posts', 'paginatedQuery', 'totalPages', 'link', 'userTable'));
    }
}