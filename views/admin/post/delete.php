<?php
use App\DbConnect;
use App\Table\PostTable;
use App\Auth;

Auth::check();

$pdo = DbConnect::getPDO();
$table = new PostTable($pdo);
$table->delete($params['id']);
header('Location: ' . $router->url('admin_posts') . '?delete=1');