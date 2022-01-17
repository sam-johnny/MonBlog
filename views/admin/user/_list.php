<tr>
    <td># <?= $user->getID() ?></td>
    <td><?= htmlentities($user->getUsername()) ?></td>
    <td><?= htmlentities($user->getEmail()) ?></td>
    <td><?= $user->getRole() ?></td>
    <td>
        <a href="<?= "/admin/user/{$user->getID()}" ?>" class="btn btn-primary">
            Editer
        </a>
        <form action="<?= "/admin/user/{$user->getID()}/delete" ?>" method="POST"
              onsubmit="return confirm('Voulez vous vraiment supprimer ce commentaire ?')"
              style="display: inline">
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </td>
</tr>
 