<?php

namespace App;

class Route
{

    /**
     * Les routes
     *
     * @return \string[][]
     */
    public static function getRoutes(): array
    {
        return [
            /*PUBLIC*/
            ['GET|POST', '/', 'HomeController#show'],
            ['GET', '/blog/category/[*:slug]-[i:id]', 'CategoryController#show'],
            ['GET', '/blog', 'PostController#blog'],
            ['GET|POST', '/blog/[*:slug]-[i:id]', 'PostController#show'],
            ['GET|POST', '/contact', 'ContactController#show'],
            ['GET|POST', '/register', 'AuthController#register'],
            ['GET|POST', '/login', 'AuthController#login'],
            ['GET|POST', '/logout', 'AuthController#logout'],
            /*ADMIN*/
            /*Gestion des articles*/
            ['GET', '/admin/posts', 'AdminPostController#index'],
            ['GET|POST', '/admin/post/[i:id]', 'AdminPostController#edit'],
            ['POST', '/admin/post/[i:id]/delete', 'AdminPostController#delete'],
            ['GET|POST', '/admin/post/new', 'AdminPostController#new'],
            /*Gestion des catégories*/
            ['GET', '/admin/categories', 'AdminCategoryController#index'],
            ['GET|POST', '/admin/category/[i:id]', 'AdminCategoryController#edit'],
            ['POST', '/admin/category/[i:id]/delete', 'AdminCategoryController#delete'],
            ['GET|POST', '/admin/category/new', 'AdminCategoryController#new'],
            /*Gestion des commentaires*/
            ['GET', '/admin/comments', 'AdminCommentController#index'],
            ['GET|POST', '/admin/comment/[i:id]/validate', 'AdminCommentController#validate'],
            ['POST', '/admin/comment/[i:id]/delete', 'AdminCommentController#delete'],
            /*Gestion des rôles*/
            ['GET', '/admin/users', 'AdminUserController#index'],
            ['GET|POST', '/admin/user/[i:id]', 'AdminUserController#edit'],
            ['POST', '/admin/user/[i:id]/delete', 'AdminUserController#delete']
        ];
    }
}