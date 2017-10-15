<?php

namespace litemerafrukt\Comments;

use \PHPUnit\Framework\TestCase;

/**
 * Test cases for Right
 */

class CommentsTest extends TestCase
{
    protected static $db;

    public static function setUpBeforeClass()
    {
        self::$db = setUpTestDb();
    }

    public static function tearDownAfterClass()
    {
        self::$db = null;
    }

    public function testCreateHandler()
    {
        $com = new Comments(new CommentHandler(self::$db));
        $this->assertInstanceOf(Comments::class, $com);
    }

    public function testCreateGetHTMLAndDeleteForCommentsPost100()
    {
        $postId = 100;
        $parentId = 0;
        $authorId = 1;
        $authorName = 'Whoever';
        $text = 'Whatever';

        $comments = new Comments(new CommentHandler(self::$db));

        $comments->new($postId, $parentId, $authorId, $authorName, $text);

        $html = $comments->getHtml($postId);

        // Check that our comment is in there
        $this->assertRegExp('/Whatever/', $html);

        // Check that there are no form tags sense no user or admin
        $this->assertNotRegExp('/<form/', $html);

        $comments->deleteComments(100);
    }

    /**
     * @expectedException \Exception
     */
    public function testThrowOnMissingViewFile()
    {
        $coms = new Comments(new CommentHandler(self::$db), __DIR__. "/thisviewfileaintthere");
        $coms->getHtml(1);
    }

    public function testCreateAndUpdateComment()
    {
        $postId = 100;
        $parentId = 0;
        $authorId = 1;
        $authorName = 'Whoever';
        $text = 'Whatever';

        $comments = new Comments(new CommentHandler(self::$db));

        $comments->new($postId, $parentId, $authorId, $authorName, $text);

        $lastInsertId = self::$db->pdo()->lastInsertId();

        $comments->update($lastInsertId, "Changed", function ($comment) use ($authorId) {
            return $comment['authorId'] == $authorId;
        });

        $html = $comments->getHtml($postId);

        $this->assertRegExp('/Changed/', $html);

        $comments->deleteComments(100);
    }

    public function testGuardUpdateComment()
    {
        $postId = 100;
        $parentId = 0;
        $authorId = 1;
        $authorName = 'Whoever';
        $text = 'Whatever';

        $fishyAuthorId = 2222;

        $comments = new Comments(new CommentHandler(self::$db));

        $comments->new($postId, $parentId, $authorId, $authorName, $text);

        $lastInsertId = self::$db->pdo()->lastInsertId();

        $comments->update($lastInsertId, "Changed", function ($comment) use ($fishyAuthorId) {
            return $comment['authorId'] == $fishyAuthorId;
        });

        $html = $comments->getHtml($postId);

        $this->assertNotRegExp('/Changed/', $html);

        $comments->deleteComments(100);
    }

    public function testNoNewCommentOnEmptyText()
    {
        $postId = 100;
        $parentId = 0;
        $authorId = 1;
        $authorName = 'This author name should not be there';
        $text = ' ';

        $comments = new Comments(new CommentHandler(self::$db));

        $comments->new($postId, $parentId, $authorId, $authorName, $text);

        $html = $comments->getHtml($postId);

        $this->assertNotRegExp("/$authorName/", $html);
    }
}
