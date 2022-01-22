<!--Section : Editer un article-->
<section class="my-5">

    <h1 class="my-5">Editer le rôle de <?= $user->getUsername() ?></h1>

    <!--Message de confirmation pour les modifications d'article-->
    <?php if ($success) : ?>
        <div class="alert alert-success">Modification réussie</div>
    <?php endif; ?>

    <!--Formulaire de modification du rôle-->
    <form action="" method="POST">
        <?= $form->input('username', "Nom d'utilisateur"); ?>
        <?= $form->input('password', "Mot de passe"); ?>
        <?= $form->input('email', "Adresse mail"); ?>

        <label for="fieldrole">Role</label>
        <select class="form-select" id="fieldrole" name="role">
            <option value="admin" <?= $selected = $user->getRole() === 'admin' ? 'selected' : ''?>>admin</option>
            <option value="membre" <?= $selected = $user->getRole() === 'membre' ? 'selected' : ''?>>membre</option>
        </select>
        <button class="btn btn-dark mt-3">
                Modifier
        </button>
    </form>
</section>
