<?php

use App\DbConnect;
use App\Table\PostTable;
use App\Auth;

Auth::check();

$title = "Administration";
$pdo = DbConnect::getPDO();
$link = $router->url('admin_posts');
[$posts, $pagination] = (new PostTable($pdo))->findPaginated();

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
        <th>
            <a href="<?= $router->url('new_post') ?>" class="btn btn-primary">Créer</a>
        </th>
    </thead>
    <tbody>
    <?php foreach ($posts as $post): ?>
        <tr>
            <td># <?= $post->getID() ?></td>
            <td>
                <a href="<?= $router->url('edit_post', ['id' => $post->getID()]) ?>">
                    <?= $post->getName() ?>
                </a>
            </td>
            <td>
                <a href="<?= $router->url('edit_post', ['id' => $post->getID()]) ?>" class="btn btn-primary">
                    Editer
                </a>
                <form action="<?= $router->url('delete_post', ['id' => $post->getID()]) ?>" method="POST"
                    onsubmit="return confirm('Voulez vous vraiment supprimer cette article ?')" style="display: inline">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousPage($link); ?>
    <?= $pagination->nextPage($link); ?>
</div>