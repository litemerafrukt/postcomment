<form class="comment-edit-form noshow" method="post">
    <textarea name="comment-text" cols="25" rows="3"><?= $commentText ?></textarea>
    <br>
    <input type="hidden" name="comment-id" value="<?= $editComment ?>">
    <input type="submit" name="edit-comment-submitted" value="Ändra">
</form>
