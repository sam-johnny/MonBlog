<?php
use App\DbConnect;
use App\HTML\Form;
use App\Table\PostTable;
use App\Validators\PostValidator;
use App\ObjectHelper;
use App\Model\Post;


$errors = [];
$post = new Post();

if (!empty($_POST)) {
    $pdo = DbConnect::getPDO();
    $postTable = new PostTable($pdo);
    $v = new PostValidator($_POST, $postTable, $post->getID());
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    if ($v->validate()) {
        $postTable->create($post);
        header('Location: ' . $router->url('edit_post', ['id' => $post->getID()]) . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);
?>

<h1>Créer un article</h1>
<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">L'article n'a pas pu être crée</div>
<?php endif; ?>

<?php require('_form.php') ?>
