<section class="my-5">
    <!--Message d'erreur-->
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">La catégorie n'a pas pu être crée</div>
    <?php endif; ?>

    <h3 class="my-5">Créer une catégorie</h3>

    <!--Formulaire de création d'article-->
    <?php require('_form.php') ?>
</section>



