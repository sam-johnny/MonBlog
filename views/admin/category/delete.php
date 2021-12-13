<?php
use App\DbConnect;
use App\Table\CategoryTable;
use App\Auth;

Auth::check();

$pdo = DbConnect::getPDO();
$table = new CategoryTable($pdo);
$table->delete($params['id']);
header('Location: ' . $router->url('admin_categories') . '?delete=1');