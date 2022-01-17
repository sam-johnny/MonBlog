<!--Section : Editer un article-->
<section class="my-5">
    <!--Message d'erreur-->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            L'article n'a pas pu être enregistré, merci de corriger vos erreurs
        </div>
    <?php endif ?>

    <h3 class="my-5">Créer un article</h3>

    <!--Formulaire de création d'article-->
    <?php require('_form.php') ?>

</section>
