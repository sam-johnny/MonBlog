<header class="masthead bg-dark text-white text-center">
    <div class="container d-flex align-items-center flex-column">
        <!--Image-->
        <img src="/img/avatar.svg" alt="SAM johnny" class="masthead-avatar mb-5" style="width:170px;height:170px">

        <h1 class="masthead-heading masthead-avatar-uppercase mb-3">SAM Johnny</h1>

        <p class="masthead-subheading font-weight-light mb-5">étudiant développeur PHP / Symfony chez OpenClassrooms</p>
    </div>
</header>

<!--Section : Liste des articles-->
<section class="my-5">
    <h3 class="my-3 text-center">La liste des articles</h3>
    <!--Cards-->
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-12">
                <?php require 'cardPost.php' ?>
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


