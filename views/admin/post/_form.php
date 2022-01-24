<!--Formulaire-->
<form action="" method="POST">
    <?= $form->input('title', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->input('chapo', 'Chapô'); ?>
    <?= $form->select('categories_ids', 'Catégories', $categories); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?php if ($_SERVER["REQUEST_URI"] !== '/admin/post/new'): ?>
    <fieldset disabled>
        <?= $form->inputUpdateDate('update_at', 'Modifié le'); ?>
    </fieldset>
    <?php endif; ?>

    <button class="btn btn-dark mt-3">
        <?php if ($post->getID() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif; ?>
    </button>
</form>
