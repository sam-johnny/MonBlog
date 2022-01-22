<section class="my-5">
    <h3 class="my-5">Gestion des commentaires</h3>

    <!--Message de confirmation pour les modifications d'article-->
    <?php if (isset($_GET['validated'])) : ?>
        <div class="alert alert-success">Le commentaire a bien été validé</div>
    <?php endif; ?>
    <!--Message de confirmation pour les suppression d'article-->
    <?php if (isset($_GET['delete'])): ?>
        <div class="alert alert-success">
            L'enregistrement a bien été supprimé
        </div>
    <?php endif; ?>
    <!--Tableau-->
    <table class="table">
        <!--Titre des colonnes-->
        <thead>
        <th>Id</th>
        <th>Nom</th>
        <th>Date</th>
        <th>Email</th>
        <th>Commentaire</th>
        <th>Titre article</th>
        </thead>
        <!--Contenu-->
        <tbody>
        <?php foreach ($comments as $comment): ?>
            <?php
            require('_list.php');
            ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
