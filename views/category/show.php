<!--Section : La liste article par catégorie-->
<section class="my-5">
    <h1 class="my-5">Catégorie : <?= $title ?> </h1>
    <!--Card pour les articles-->
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-12">
                <?php require dirname(__DIR__) . '/post/cardPost.php' ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!--Pagination-->
<?php if ($totalPages > 1): ?>
<div class="my-5">
    <ul class="pagination justify-content-center">
        <?= $paginatedQuery->previousPage($link) ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?= $paginatedQuery->numPage($link, $i) ?>
        <?php endfor; ?>
        <?= $paginatedQuery->nextPage($link); ?>
</div>
<?php endif; ?>