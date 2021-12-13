<?php

use App\DbConnect;
use App\Table\CategoryTable;
use App\Auth;

Auth::check();

$title = "Gestion des catégories";
$pdo = DbConnect::getPDO();
$link = $router->url('admin_categories');
$items = (new CategoryTable($pdo))->all();

?>

<?php if (isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        L'enregistrement a bien été supprimé
    </div>
<?php endif; ?>
<table class="table">
    <thead>
        <th>Id</th>
        <th>Titre</th>
        <th>URL</th>
        <th>
            <a href="<?= $router->url('new_category') ?>" class="btn btn-primary">Créer</a>
        </th>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <td># <?= $item->getID() ?></td>
            <td>
                <a href="<?= $router->url('edit_category', ['id' => $item->getID()]) ?>">
                    <?= $item->getName() ?>
                </a>
            </td>
            <td><?= $item->getSlug() ?></td>
            <td>
                <a href="<?= $router->url('edit_category', ['id' => $item->getID()]) ?>" class="btn btn-primary">
                    Editer
                </a>
                <form action="<?= $router->url('delete_category', ['id' => $item->getID()]) ?>" method="POST"
                    onsubmit="return confirm('Voulez vous vraiment supprimer cette catégorie ?')" style="display: inline">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
