<li class="comment-li">
    <p class="comment-author-created">
        <strong><?= htmlentities($comment['authorName']) ?></strong> @ <?= $comment['created'] ?> & <?= $comment['updated'] ?>
    </p>
    <p>
        <?= nl2br(htmlentities($comment['text'])) ?>
    </p>
    <?php if ($user) : ?>
        <button class="comment-next-sibling-toggler comment-button">
            svara
        </button>
            <?php
                $replyToComment = $comment['id'];
                include __DIR__."/replyform.php";
            ?>
    <?php endif ?>

    <?php if ($admin || ($user && $userId == $comment['authorId'])) : ?>
        <button class="comment-next-sibling-toggler comment-button">
            editera
        </button>
            <?php
                $editComment = $comment['id'];
                $commentText = htmlentities($comment['text']);
                include __DIR__."/editform.php";
            ?>
    <?php endif ?>

    <?php if (isset($commentGroups[$comment['id']])) : ?>
        <?php
            $comments = $commentGroups[$comment['id']];
            include __DIR__.'/commentlist.php';
        ?>
    <?php endif ?>
</li>
