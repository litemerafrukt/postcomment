<?php

namespace litemerafrukt\Comments;

use \PHPUnit\Framework\TestCase;

class CommentHandlerTest extends TestCase
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
        $chand = new CommentHandler(self::$db);
        $this->assertInstanceOf(CommentHandler::class, $chand);
    }

    public function testCreateAndRetrieveComment()
    {
        $postId = 100;
        $parentId = 0;
        $authorId = 1;
        $authorName = 'Whoever';
        $text = 'Whatever';

        $chand = new CommentHandler(self::$db);

        $chand->new($postId, $parentId, $authorId, $authorName, $text);

        $lastId = self::$db->pdo()->lastInsertId();

        $com = $chand->fetch($lastId);

        $this->assertEquals($postId, $com['postId']);
        $this->assertEquals($parentId, $com['parentId']);
        $this->assertEquals($authorId, $com['authorId']);
        $this->assertEquals($authorName, $com['authorName']);
        $this->assertEquals($text, $com['text']);

        $this->assertNotNull($com['created']);
        $this->assertNull($com['updated']);

        $chand->deleteComments(100);
    }

    public function testCreateAndRetrieveCommentsForPost()
    {
        $postId = 100;
        $parentId = 0;
        $authorId = 1;
        $authorName = 'Whoever';
        $text = 'Whatever';

        $chand = new CommentHandler(self::$db);

        $chand->new($postId, $parentId, $authorId, $authorName, $text);

        $comForPost100 = $chand->commentsForPost(100);

        $this->assertEquals(count($comForPost100), 1);

        $com = $comForPost100[$parentId][0];

        $this->assertEquals($postId, $com['postId']);
        $this->assertEquals($parentId, $com['parentId']);
        $this->assertEquals($authorId, $com['authorId']);
        $this->assertEquals($authorName, $com['authorName']);
        $this->assertEquals($text, $com['text']);

        $this->assertNotNull($com['created']);
        $this->assertNull($com['updated']);
    }

    public function testCreateAndUpsertComment()
    {
        $postId = 100;
        $parentId = 0;
        $authorId = 1;
        $authorName = 'Whoever';
        $text = 'Whatever';

        $chand = new CommentHandler(self::$db);

        $chand->new($postId, $parentId, $authorId, $authorName, $text);

        // $comForPost100 = $chand->commentsForPost(100);

        $lastInsertId = self::$db->pdo()->lastInsertId();

        $chand->upsert($lastInsertId, "Changed");

        $resCom = $chand->fetch($lastInsertId);

        $this->assertEquals("Changed", $resCom['text']);
        $this->assertNotNull($resCom['updated']);
    }
}
