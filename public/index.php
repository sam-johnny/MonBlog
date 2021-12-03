<?php
require '../vendor/autoload.php';

/* -- Pour savoir le début du temps de chargement -- */
define('DEBUG_TIME', microtime(true));

/* -- Pour avoir une belle page d'erreur -- */
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


/* -- Le routeur -- */
$router = new App\Router(dirname(__DIR__) . '/views');
$router
    ->get('/', 'post/index', 'home')
    ->get('/blog/category/', 'category/show', 'category')
    ->get('/blog', 'post/show', 'post')
    ->run();

