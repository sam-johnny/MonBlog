<?php
require '../vendor/autoload.php';

/* -- Pour savoir le début du temps de chargement -- */
define('DEBUG_TIME', microtime(true));

/* -- Pour avoir une belle page d'erreur -- */
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

/* -- Redirection url si dans url contient ?page=1 -- */
if (isset($_GET['page']) && $_GET['page'] === "1") {
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($get);
    if (!empty($query)) {
        $uri = $uri . '?' . $query;
    }
    http_response_code(301);
    header('Location: ' . $uri);
    exit();
}

/* -- Le routeur -- */
$router = new App\Router(dirname(__DIR__) . '/views');
$router
    ->get('/', 'post/index', 'home')
    ->get('/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
    ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->get('/admin', 'admin/post/index', 'admin_posts')
    ->match('/admin/post/[i:id]', 'admin/post/edit', 'edit_post')
    ->post('/admin/post/[i:id]/delete', 'admin/post/delete', 'delete_post')
    ->match('/admin/post/new', 'admin/post/new', 'new_post')
    ->run();

