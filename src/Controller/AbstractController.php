<?php

namespace App\Controller;


use App\Security\ForbiddenException;

abstract class AbstractController
{
    protected function render(string $view, array $variables = [])
    {
        try {
            extract($variables);
            ob_start();
            require dirname((dirname(__DIR__))) . '/views/' . $view . '.php';
            $content = ob_get_clean();

            require dirname((dirname(__DIR__))) . '/views/layouts/default.php';
        } catch (ForbiddenException $e) {
            header('Location: ' . '/login?forbidden=1');
            exit();
        }
    }
}