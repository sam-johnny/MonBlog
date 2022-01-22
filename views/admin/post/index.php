<!--Section : Gestion des articles-->
<section class="my-5">
    <!--Message de confirmation pour suppression d'article-->
    <?php if (isset($_GET['delete'])): ?>
        <div class="alert alert-success">
            L'article a bien été supprimé
        </div>
    <?php endif; ?>

    <h3 class="my-5">Gestion des articles</h3>
    <!--Tableau-->
    <table class="table">
        <!--Titre des colonnes-->
        <thead>
        <th>Id</th>
        <th>Titre</th>
        <th>
            <a href="/admin/post/new" class="btn btn-primary">Nouveau</a>
        </th>
        </thead>
        <!--Contenu-->
        <tbody>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td># <?= $post->getID() ?></td>
                <td>
                    <a href="<?= "/blog/{$post->getSlug()}-{$post->getId()}" ?>">
                        <?= $post->getTitle() ?>
                    </a>
                </td>
                <td>
                    <a href="<?= "/admin/post/{$post->getID()}" ?>" class="btn btn-primary">
                        Editer
                    </a>
                    <form action="<?= "/admin/post/{$post->getID()}/delete" ?>" method="POST"
                          onsubmit="return confirm('Voulez vous vraiment supprimer cette article ?')"
                          style="display: inline">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>