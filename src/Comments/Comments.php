<?php

namespace litemerafrukt\Comments;

class Comments
{
    private $commentHandler;
    private $rootView;

    /**
     * Construct
     *
     * @param $db - database objekt. See source for interface.
     * @param $rootView - root view file for comments html rendering. See source for example.
     */
    public function __construct($commentHandler, $rootView = __DIR__.'/../../view/comments.php')
    {
        $this->commentHandler = $commentHandler;
        $this->rootView = $rootView;
    }

    /**
     * Create a comment
     *
     * @param $postId
     * @param $parentId - parent comment
     * @param $authorId - author/user id
     * @param $authorName - author/user name
     * @param $text - comment text
     *
     * @return void
     */
    public function new($postId, $parentId, $authorId, $authorName, $text)
    {
        if (\trim($text) === "") {
            return;
        }

        $this->commentHandler->new($postId, $parentId, $authorId, $authorName, $text);
    }

    /**
     * Update a comment
     *
     * @param $id - comment id
     * @param $text - comment text
     * @param $guard - function, comment only updates if guard returns true
     *
     * @return bool
     */
    public function update($id, $text, $guard)
    {
        $comment = $this->commentHandler->fetch($id);

        if (! $guard($comment)) {
            return false;
        }

        $this->commentHandler->upsert($id, $text);
        return true;
    }

    /**
     * Delete all comments assosiated with a post.
     *
     * @param $postId
     *
     * @return void
     */
    public function deleteComments($postId)
    {
        $this->commentHandler->deleteComments($postId);
    }

    /**
     * Get comment html for a post. All comments and save/edit forms.
     *
     * @param $postId
     * @param $user - true if there is user previlages.
     * @param $admin - true if admin previleges.
     * @param $username
     * @param $userId
     *
     * @return string
     */
    public function getHtml($postId, $user = false, $admin = false, $username = "unknown", $userId = null)
    {
        $commentGroups = $this->commentHandler->commentsForPost($postId);

        return $this->render($this->rootView, \compact('commentGroups', 'user', 'admin', 'username', 'userId'));
    }

    /**
     * Render view file with data.
     *
     * @param $file
     * @param $data
     * @return string
     * @throws \Exception
     */
    private function render($file, $data)
    {
        if (!file_exists($file)) {
            throw new \Exception("View template not found: $file.");
        }

        ob_start();

        extract($data);

        include $file;

        $output = ob_get_clean();

        return $output;
    }
}
