<?php

use App\DbConnect;
use App\HTML\Form;
use App\Table\PostTable;
use App\Validators\PostValidator;
use App\ObjectHelper;

$pdo = DbConnect::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;


$errors = [];

if (!empty($_POST)) {
    $v = new PostValidator($_POST, $postTable, $post->getID());
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    if ($v->validate()) {
        $postTable->update($post);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);
?>

    <h1>Editer l'article <?= $post->getName() ?></h1>
<?php if ($success) : ?>
    <div class="alert alert-success">Modification réussie</div>
<?php endif; ?>
<?php if (isset($_GET['created'])) : ?>
    <div class="alert alert-success">L'article a bien été créé</div>
<?php endif; ?>
<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">L'article n'a pas pu être modifié</div>
<?php endif; ?>

<?php require('_form.php'); ?>