<?php

namespace litemerafrukt\Comments;

use jakezatecky\array_group_by;

class CommentHandler
{
    private $db;
    private $table;

    public function __construct($db, $table = 'r1_comments')
    {
        $this->db = $db;
        $this->table = $table;
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
        $sql = "INSERT INTO $this->table (postId, parentId, authorId, authorName, `text`) VALUES (?, ?, ?, ?, ?)";
        $this->db->query($sql, [$postId, $parentId, $authorId, $authorName, $text]);
    }

    /**
     * Get a comment
     *
     * @param $id - comment id
     *
     * @return array - the comment
     */
    public function fetch($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id=?";
        return $this->db->query($sql, [$id])->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Update a comments text.
     *
     * @param $id - comment id
     * @param $text - new text
     *
     * @return void
     */
    public function upsert($id, $text)
    {
        $updated = \date("Y-m-d H:i:s");
        $sql = "UPDATE $this->table SET `text`=?, updated=? WHERE id=?";
        $this->db->query($sql, [$text, $updated, $id]);
    }

    /**
     * Delete all comments associated with a post.
     *
     * @param $postId
     *
     * @return void
     */
    public function deleteComments($postId)
    {
        $sql = "DELETE FROM $this->table WHERE postId=?";
        $this->db->query($sql, [$postId]);
    }

    /**
     * Get comments for a post.
     *
     * @param $id - post id
     *
     * @return array - comments grouped by parent comment
     */
    public function commentsForPost($id)
    {
       // Lookup in database
        $sql = "SELECT * from $this->table WHERE postId=?";
        // $comments = $this->db->query2collection($sql, [$id])
        //     ->groupBy('parentId');

        $comments = $this->db->query($sql, [$id])
            ->fetchAll(\PDO::FETCH_ASSOC);

        $groupedComments = array_group_by($comments, 'parentId');

        return $groupedComments;

        // return $comments->toArray();
    }
}
