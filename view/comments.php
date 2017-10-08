<div class="post-comments">

    <?php if ($user) : ?>
    <form class="comment-top-reply-form" method="post">
        <textarea name="comment-text" cols="25" rows="3"></textarea>
        <br>
        <input type="hidden" name="parent-id" value="0">
        <input type="submit" name="new-comment-submitted" value="Svara">
    </form>
    <?php else : ?>
        <p>Logga in för att kommentera</p>
    <?php endif ?>

    <?php if (isset($commentGroups[0])) : ?>
        <?php
            $comments = $commentGroups[0];
            include __DIR__.'/commentlist.php';
        ?>
    <?php endif ?>

    <script>
        var commentReplyTogglers = document.getElementsByClassName("comment-next-sibling-toggler");
        for (var i = 0, l = commentReplyTogglers.length; i < l; i++ ) {
            commentReplyTogglers[i].addEventListener('click', function (ev) {
                var nextSibling = ev.target.nextElementSibling;
                // ev.target.classList.toggle('noshow');
                nextSibling.classList.toggle('noshow');
            })
        }
    </script>
</div>
