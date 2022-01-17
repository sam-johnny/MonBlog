<?php $post = $posts->find($comment->getPostId())?>
<tr>
    <td># <?= $comment->getID() ?></td>
    <td><?= htmlentities($comment->getUsername()) ?></td>
    <td><?= $comment->getCreatedAt()->format('d/m/Y à H:i:s') ?></td>
    <td><?= htmlentities($comment->getEmail()) ?></td>
    <td><?= $comment->getFormattedContent() ?></td>
    <td>
        <a href="<?= "/blog/{$post->getSlug()}-{$post->getID()}" ?>"><?= $post->getTitle() ?></a>
    </td>

    <td>
        <form action="<?= "/admin/comment/{$comment->getID()}/validate" ?>" method="POST"
              onsubmit="return confirm('Voulez vous vraiment confirmer ce commentaire ?')"
              style="display: inline">
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
        <form action="<?= "/admin/comment/{$comment->getID()}/delete" ?>" method="POST"
              onsubmit="return confirm('Voulez vous vraiment supprimer ce commentaire ?')"
              style="display: inline">
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </td>
</tr>
 