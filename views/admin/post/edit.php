<!--Section : Editer un article-->
<section class="my-5">

    <h1 class="my-5">Editer l'article <?= $post->getTitle() ?></h1>

    <!--Message de confirmation pour les modifications d'article-->
    <?php if ($success) : ?>
        <div class="alert alert-success">Modification réussie</div>
    <?php endif; ?>

    <!--Message de confirmation pour les créations d'article-->
    <?php if (isset($_GET['created'])) : ?>
        <div class="alert alert-success">L'article a bien été créé</div>
    <?php endif; ?>

    <!--Message d'erreur pour les modifications d'article-->
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">L'article n'a pas pu être modifié</div>
    <?php endif; ?>

    <!--Formulaire de modification d'article-->
    <?php require('_form.php'); ?>

</section>
