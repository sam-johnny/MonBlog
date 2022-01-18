<section class="my-5">
    <!--Message de confirmation pour les suppression de catégorie-->
    <?php if (isset($_GET['delete'])): ?>
        <div class="alert alert-success">
            L'enregistrement a bien été supprimé
        </div>
    <?php endif; ?>
    <!--Message de confirmation pour les créations de catégorie-->
    <?php if (isset($_GET['created'])) : ?>
        <div class="alert alert-success">La catégorie a bien été créé</div>
    <?php endif; ?>

    <h3 class="my-5">Gestion des catégories</h3>
    <!--Tableau-->
    <table class="table">
        <!--Titre des colonnes-->
        <thead>
        <th>Id</th>
        <th>Titre</th>
        <th>URL</th>
        <th>
            <a href="<?= '/admin/category/new' ?>" class="btn btn-primary">Nouveau</a>
        </th>
        </thead>
        <!--Contenu-->
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td># <?= $category->getID() ?></td>
                <td>
                    <a href="<?= "/blog/category/{$category->getSlug()}-{$category->getId()}" ?>">
                        <?= $category->getName() ?>
                    </a>
                </td>
                <td><?= $category->getSlug() ?></td>
                <td>
                    <a href="<?= "/admin/category/{$category->getID()}" ?>" class="btn btn-primary">
                        Editer
                    </a>
                    <form action="<?= "/admin/category/{$category->getID()}/delete" ?>" method="POST"
                          onsubmit="return confirm('Voulez vous vraiment supprimer cette catégorie ?')"
                          style="display: inline">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>