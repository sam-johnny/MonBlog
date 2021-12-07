<?php
$categories = [];
foreach ($post->getCategories() as $category) {
    $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
    $categories[] = <<<HTML
<a href="{$url}">{$category->getName()}</a>
HTML;
}
?>



<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= $post->getName() ?></h5>
        <p class="text-muted fst-italic"><?= $post->getCreatedAt()->format('d/m/Y') ?>
            <?php if (!empty($post->getCategories())): ?>
            :: <?= implode(', ', $categories) ?> </p>
            <?php endif; ?>
        <p><?= $post->getExcerpt() ?></p>
        <p><a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>"
              class="btn btn-primary">Voir plus</a></p>
    </div>
</div>
 