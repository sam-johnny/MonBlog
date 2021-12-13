<?php

use App\DbConnect;
use App\HTML\Form;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;
use App\ObjectHelper;
use App\Auth;

Auth::check();

$pdo = DbConnect::getPDO();
$table = new CategoryTable($pdo);
$item = $table->find($params['id']);
$success = false;
$errors = [];
$fields = ['name', 'slug'];

if (!empty($_POST)) {
    $v = new CategoryValidator($_POST, $table, $item->getID());
    ObjectHelper::hydrate($item, $_POST, $fields);
    if ($v->validate()) {
        $table->update([
            'name' => $item->getName(),
            'slug' => $item->getSlug()
        ], $item->getID());
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($item, $errors);
?>

    <h1>Editer la catégorie <?= $item->getName() ?></h1>
<?php if ($success) : ?>
    <div class="alert alert-success">Modification réussie</div>
<?php endif; ?>
<?php if (isset($_GET['created'])) : ?>
    <div class="alert alert-success">La catégorie a bien été créé</div>
<?php endif; ?>
<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">La catégorie n'a pas pu être modifié</div>
<?php endif; ?>

<?php require('_form.php'); ?>