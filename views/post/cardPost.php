<?php
/*Récupération des catégories*/
$categories = [];
foreach ($post->getCategories() as $category) {
    $url = "/blog/category/{$category->getSlug()}-{$category->getID()}";
    $categories[] = <<<HTML
<a href="{$url}">{$category->getFormattedName()}</a>
HTML;
}

$user = $userManager->find($post->getUserID());
?>
<!--Cards pour la liste des articles-->
<div class="card mb-3 bg-light">
    <div class="card-body">
        <!--Titre-->
        <h5 class="card-title"><?= $post->getTitle() ?></h5>
        <!--date de publication-->
        <p class="text-muted fst-italic"><?= $post->getCreatedAt()->format('d/m/Y') ?>
            <!--Catégories-->
            <?php if (!empty($post->getCategories())): ?>
            :: <?= implode(' / ', $categories) ?> </p>
        <?php endif; ?>
        <!--date de modification-->
        <?php if ($post->getUpdateAt() >= $post->getCreatedAt()): ?>
        <p class="text-muted fst-italic">Modifié le <?= $post->getUpdateAt()->format('d/m/Y') ?>
            <?php endif;?>
        <!--Auteur-->
        <p class="text-muted fst-italic">publié par <?= $user->getUsername() ?></p>
        <!--Chapô-->
        <p class="fw-bold"><?= $post->getChapo() ?></p>
        <!--Extrait du contenu de l'article-->
        <p><?= $post->getExcerpt() ?></p>
        <!--Bouton-->
        <p><a href="<?= "/blog/{$post->getSlug()}-{$post->getID()}" ?>"
              class="btn btn-dark">Voir plus</a></p>
    </div>
</div>
