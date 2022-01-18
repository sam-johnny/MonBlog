<header class="bg-dark text-white text-center">
    <div class="container d-flex align-items-center flex-column">
        <!--Image-->
        <img src="/img/avatar.svg" alt="SAM johnny" class="mb-5" style="width:170px;height:170px">
        <h1 class="mb-3">SAM Johnny</h1>
        <p class="font-weight-light mb-5">étudiant développeur PHP / Symfony chez OpenClassrooms</p>
    </div>
</header>

<!--Section : A propos de moi-->
<section class="text-center my-5">
    <h3 class="my-3">A propos de moi</h3>
    <p>Etant en reconversion professionnelle et passionné par l'univers du web. J'ai commencé par me former en
        autodidacte et suivi
        des cours sur internet afin de nourrir ma curiosité. Je souhaite me spécialiser dans le developpement back-end
        et aujourd'hui, je suis étudiant chez OpenClassrooms.</p>
    <a href="/doc/cv.pdf" class="btn btn-dark" target="_blank">Voir mon cv</a>
</section>
<hr>

<!--Section : Contact-->
<section id="contact" class="text-center my-5">
    <h3 class="my-3">Me contacter</h3>
    <?php if (isset($_GET['send'])): ?>
        <div class="alert alert-success">
            Le mail a bien été envoyé
        </div>
    <?php endif; ?>
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            Le mail n'a pas pu être envoyé
        </div>
    <?php endif; ?>

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
        <button type="submit" class="btn btn-dark my-3">Envoyer</button>
    </form>
</section>
