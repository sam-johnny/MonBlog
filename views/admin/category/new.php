<?php

use App\DbConnect;
use App\HTML\Form;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;
use App\ObjectHelper;
use App\Model\Category;
use App\Auth;

Auth::check();

$errors = [];
$item = new Category();

if (!empty($_POST)) {
    $pdo = DbConnect::getPDO();
    $table = new CategoryTable($pdo);

    $v = new CategoryValidator($_POST, $table);
    ObjectHelper::hydrate($item, $_POST, ['name', 'slug']);
    if ($v->validate()) {
        $table->create([
            'name' => $item->getName(),
            'slug' => $item->getSlug()
        ]);
        header('Location: ' . $router->url('admin_categories') . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($item, $errors);
?>

<h1>Créer une catégorie</h1>
<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">La catégorie n'a pas pu être crée</div>
<?php endif; ?>

<?php require('_form.php') ?>
