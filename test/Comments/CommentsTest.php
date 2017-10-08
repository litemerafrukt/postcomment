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
        $com = new Comments(self::$db);
        $this->assertInstanceOf(Comments::class, $com);
    }

    public function testCreateAndGetHTMLForCommentsPost100()
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
}
