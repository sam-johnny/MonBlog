<!--Section : Se connecter-->
<section class="my-5">
    <!--Si utilisateur non connecté essaye d'accéder au contenu admin-->
    <?php if (isset($_GET['forbidden'])): ?>
        <div class="alert alert-danger">
            Veuillez vous connecter. Pour accéder à ce contenu.
        </div>
    <?php endif; ?>
    <!--Si inscription validé alors redirection sur cette page avec message-->
    <?php if (isset($_GET['register'])): ?>
        <div class="alert alert-success">
            Inscription réussie, vous pouvez vous connecter
        </div>
    <?php endif; ?>

    <h1>Se connecter</h1>

    <!--Formulaire de connexion-->
    <form action="/login" method="POST">
        <?= $form->input('username', "Nom d'utilisateur"); ?>
        <?= $form->input('password', "Mot de passe"); ?>
        <a href="/register">S'enregistrer</a><br>
        <button type="submit" class="btn btn-primary mt-3">Se connecter</button>
    </form>
</section>
