<?php

use App\DbConnect;
use App\Table\PostTable;


$title = 'Mon Blog';
$pdo = DbConnect::getPDO();

$table = new PostTable($pdo);
[$posts, $pagination] = $table->findPaginated();

$link = $router->url('home');
?>

<h1>Mon blog</h1>

<!--Cards-->
<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-12">
            <?php require 'card.php' ?>
        </div>
    <?php endforeach; ?>
</div>

<!--Pagination-->
<div class="my-5">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousPage($link); ?>
    <?= $pagination->nextPage($link); ?>
</div>
