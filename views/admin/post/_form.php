<!--Formulaire-->
<form action="" method="POST">
    <?= $form->input('title', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->input('chapo', 'Chapô'); ?>
    <?= $form->select('categories_ids', 'Catégories', $categories); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?= $form->inputUpdateDate('update_at', 'Modifié le'); ?>


    <button class="btn btn-dark mt-3">
        <?php if ($post->getID() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif; ?>
    </button>
</form>
