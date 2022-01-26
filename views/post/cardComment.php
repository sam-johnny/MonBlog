<?php
$userComment = $userManager->find($commentary->getUserID());
?>
<div class="col-md-12">
    <div class="card mb-3 bg-light">
        <div class="card-body">
            <h5 class="card-title"><?= htmlentities($userComment->getUsername()) ?></h5>
            <p class="text-muted fst-italic"><?= $commentary->getCreatedAt()->format('d/m/Y à H:i:s') ?>
            <p><?= $commentary->getFormattedContent() ?></p>
        </div>
    </div>
</div>