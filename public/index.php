<?php
require '../vendor/autoload.php';

/*-- Date/heure Française --*/
date_default_timezone_set('Europe/Paris');

/*-- Pour avoir une belle page d'erreur --*/
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

/*-- Dotenv --*/
$repository = Dotenv\Repository\RepositoryBuilder::createWithNoAdapters()
    ->addAdapter(Dotenv\Repository\Adapter\EnvConstAdapter::class)
    ->addWriter(Dotenv\Repository\Adapter\PutenvAdapter::class)
    ->immutable()
    ->make();
$dotenv = Dotenv\Dotenv::create($repository, __DIR__);
$dotenv->load();

/*-- Renommer url si dans url contient ?page=1 --*/
if (isset($_GET['page']) && $_GET['page'] === "1") {
    $requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($get);
    if (!empty($query)) {
        $requestUri = $requestUri . '?' . $query;
    }
    http_response_code(301);
    header('Location: ' . $requestUri);
    exit();
}

/*-- Le routeur --*/
$router = new AltoRouter();

/*-- Toutes les routes --*/
foreach (\App\Route::getRoutes() as $route) {
        $router->map(...$route);
}

$match = $router->match();

if (!$match)  {
    require dirname(__DIR__) . '\views\e404.php';
} else {
    list($controller, $action) = explode('#', $match['target']);
    $controller = 'App\\Controller\\' . $controller;
    $controller = new $controller;
    if (is_callable(array($controller, $action))) {
        call_user_func_array(array($controller, $action), array($match['params']));
    } else {
        throw new Exception('500');
    }
}

