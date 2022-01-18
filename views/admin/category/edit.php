<!--Section : Edition catégorie-->
<section class="my-5">

    <!--Message de confirmation pour les modifications de catégorie-->
    <?php if ($success) : ?>
        <div class="alert alert-success">Modification réussie</div>
    <?php endif; ?>
    <!--Message d'erreur pour les modifications d'article-->
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">La catégorie n'a pas pu être modifié</div>
    <?php endif; ?>

    <h3 class="my-5">Editer la catégorie : <?= $category->getName() ?></h3>

    <!--Formulaire d'édition de catégorie-->
    <?php require('_form.php'); ?>

</section>
