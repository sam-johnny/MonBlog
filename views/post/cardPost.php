<?php
/*Récupération des catégories*/
$categories = [];
foreach ($post->getCategories() as $category) {
    $url = "/blog/category/{$category->getSlug()}-{$category->getID()}";
    $categories[] = <<<HTML
<a href="{$url}">{$category->getFormattedName()}</a>
HTML;
}
?>

<!--Cards pour la liste des articles-->
<div class="card mb-3 bg-light">
    <div class="card-body">
        <!--Titre-->
        <h5 class="card-title"><?= $post->getTitle() ?></h5>
        <!--date-->
        <p class="text-muted fst-italic"><?= $post->getCreatedAt()->format('d/m/Y') ?>
            <!--commentaire-->
            <?php if (!empty($post->getCategories())): ?>
            :: <?= implode(' / ', $categories) ?> </p>
            <?php endif; ?>
        <!--Extrait de l'article-->
        <p><?= $post->getExcerpt() ?></p>
        <!--Bouton-->
        <p><a href="<?= "/blog/{$post->getSlug()}-{$post->getID()}" ?>"
              class="btn btn-dark">Voir plus</a></p>
    </div>
</div>
