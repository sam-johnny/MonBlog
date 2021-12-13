<form action="" method="POST">
    <?= $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?= $form->input('created_at', 'Date de publication'); ?>

    <button class="btn btn-primary mt-3">
        <?php if ($post->getID() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif; ?>
    </button>
</form>
