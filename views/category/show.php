<?php

use App\DbConnect;
use App\Table\{PostTable, CategoryTable};


$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = DbConnect::getPDO();
$category = (new CategoryTable($pdo))->find($id);

if ($category->getSlug() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code('301');
    header('Location: ' . $url);
}

$title = "Catégorie {$category->getName()}";

[$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($category->getID());

$link = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
?>


<h1><?= htmlentities($title) ?> </h1>

<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-12">
            <?php require dirname(__DIR__) . '/post/card.php' ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousPage($link) ?>
    <?= $paginatedQuery->nextPage($link) ?>

</div>