<!--Bannière-->
<header class="masthead bg-dark text-white text-center">
    <div class="container d-flex align-items-center flex-column">
        <!--Image-->
        <img src="/img/avatar.svg" alt="SAM johnny" class="masthead-avatar mb-5" style="width:170px;height:170px">

        <h1 class="masthead-heading masthead-avatar-uppercase mb-3">SAM Johnny</h1>

        <p class="masthead-subheading font-weight-light mb-5">étudiant développeur PHP / Symfony chez OpenClassrooms</p>
    </div>
</header>

<!--Section : Contact-->
<section class="my-5 text-center">
    <?php if (isset($_GET['send'])): ?>
        <div class="alert alert-success">
            Le mail a bien été envoyé
        </div>
    <?php endif; ?>
    <h3 class="my-5">Contact</h3>
    <!--Formulaire de contact-->
    <form action="" method="POST">
        <div class="row">
            <div class="col-sm-6">
                <?= $form->input('username', 'Nom') ?>
            </div>
            <div class="col-sm-6">
                <?= $form->input('email', 'Email') ?>
            </div>
            <div class="col-sm-12 mt-3">
                <?= $form->textarea('message', 'Message') ?>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-dark my-3">Envoyer</button>
        </div>
    </form>
</section>