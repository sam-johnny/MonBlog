<!--Section : S'enregistrer-->
<section class="my-5">
    <h1 class="my-4">S'enregistrer</h1>
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">L'enregistrement n'a pas pu être crée</div>
    <?php endif; ?>
    <!--Formulaire-->
    <?php require('_form.php') ?>
</section>
