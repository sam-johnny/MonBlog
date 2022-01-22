<!--Section : Article-->
<section class="my-5">

    <!--Message de confirmation de commentaire-->
    <?php if (isset($_GET['commented'])): ?>
        <div class="alert alert-success">Votre commentaire a bien été envoyé. <br>
            <small class="text-muted">Il s'affichera une fois que l'administrateur le validera</small>
        </div>
    <?php endif; ?>
    <!--Le Titre-->
    <h1><?= $post->getTitle() ?></h1>
    <!--La date-->
    <p class="text-muted fst-italic">
        <?= $post->getCreatedAt()->format('d/m/Y') ?> ::
        <!--Liste des catégories-->
        <?php foreach ($post->getCategories() as $k => $category):
            if ($k > 0):
                echo " / ";
            endif;
            $category_url = "/blog/category/{$category->getSlug()}-{$category->getID()}"; ?>
            <a href="<?= $category_url ?>"><?= htmlentities($category->getName()) ?></a><?php endforeach; ?>
    </p>
    <!--date de modification-->
    <?php if (!empty($post->getUpdateAt())): ?>
    <p class="text-muted fst-italic">Modifié le <?= $post->getUpdateAt()->format('d/m/Y') ?>
        <?php endif;?>
    <!--Auteur-->
    <p class="text-muted fst-italic">Publié par <?= $user->getUsername()?></p>
    <!--Chapô-->
    <p class="fw-bold"><?= $post->getChapo()?></p>
    <!--Le contenu-->
    <p><?= $post->getFormattedContent() ?></p>
</section>
<hr>

<!--Section : Commentaire-->
<section class="my-5">
    <h2><?= count($comments) ?> Commentaires</h2>

    <?php if (isset($_SESSION['auth'])) : ?>
        <!-- Formulaire commentaire -->
        <form action="" method="POST">
            <fieldset disabled>
                <?= $form->inputComment('username', 'Pseudo', $_SESSION['auth']['username']); ?>
                <?= $form->inputComment('email', 'Adresse mail', $_SESSION['auth']['email']); ?>
            </fieldset>
            <?= $form->textarea('content', 'Commentaire'); ?>
            <button type="submit" class="btn btn-dark my-3">Envoyer</button>
        </form>
        <hr>
    <?php endif; ?>

    <!-- Affichage des commentaires -->
    <?php foreach ($comments as $commentary): ?>
            <?php require ('cardComment.php')?>
    <?php endforeach; ?>
</section>


