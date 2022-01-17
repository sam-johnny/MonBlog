<!--Formulaire-->
<form action="" method="POST">
    <?= $form->input('username', "Nom d'utilisateur"); ?>
    <?= $form->input('email', "Adresse mail"); ?>
    <?= $form->input('password', "Mot de passe"); ?>
    <button class="btn btn-primary mt-3">S'enregistrer</button>
</form>
