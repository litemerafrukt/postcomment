Anax postcomments
==================================

<!--
[![Latest Stable Version](https://poser.pugx.org/anax/postcomments/v/stable)](https://packagist.org/packages/anax/postcomments)
[![Join the chat at https://gitter.im/mosbth/anax](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/canax?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
-->
[![Build Status](https://travis-ci.org/litemerafrukt/postcomments.svg?branch=master)](https://travis-ci.org/litemerafrukt/postcomments)
[![CircleCI](https://circleci.com/gh/litemerafrukt/postcomments.svg?style=svg)](https://circleci.com/gh/litemerafrukt/postcomments)
<!--
[![Build Status](https://scrutinizer-ci.com/g/canax/postcomments/badges/build.png?b=master)](https://scrutinizer-ci.com/g/canax/postcomments/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/canax/postcomments/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/canax/postcomments/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/canax/postcomments/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/canax/postcomments/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d831fd4c-b7c6-4ff0-9a83-102440af8929/mini.png)](https://insight.sensiolabs.com/projects/d831fd4c-b7c6-4ff0-9a83-102440af8929)
-->

Reddit-like comments to posts.

Uses view-files recursively to achieve nested comments. There are default view files. If you want to define your own views then look at the included view files for examples. The `Comments` class takes a top level view file as optional parameter.

`CommentsHandler` class needs a simple database class with a `query`-method. Look at the supplied `Database` class for the interface if you want to build your own. The database needs to be setup with a comments table, se `src/extras` folder for schema. Table name can optionally be supplied to `CommentsHandler` constructor, defaults to `r1_comments`.

This module is built to fit in an [Anax](https://github.com/canax) project but should fit in to any project with a little work. At the same time, this is not a fit all package, this is written for a specific project.

Install
------------------

PHP version > 7.0.

`$ composer require litemerafrukt/postcomments`

Setup your database with a table for the commments, see `vendor/litemerafrukt/postcomments/src/extras`.

Use database class with namespace `litemerafrukt\Database` or supply your own class with a query-metod, see `vendor/litemerafrukt/postcomments/src/Database/Database.php` for interface.


Usage
------------------

Set up your forum post controller to handle both get and post requests. The postcomments module will supply the view with html for the comments.

Example from an Anax project.

```PHP
class PostController

    /**
     * Show a post
     *
     * @param int $postId
     */
    public function showPost($id)
    {
        $post = $this->posts->fetch($id);

        $user = $this->di->get('user');
        $user->isUser = $user->isLevel(UserLevels::USER);
        $user->isAdmin = $user->isLevel(UserLevels::ADMIN);

        $comments = new Comments(new CommentHandler($this->di->get('olddb')));

        if ($this->di->request->getPost('new-comment-submitted', false) && $user) {
            $authorId = $user->id;
            $authorName = $user->name;
            $parentId = $this->di->request->getPost('parent-id', 0);
            $text = \trim($this->di->request->getPost('comment-text'));
            $comments->new($id, $parentId, $authorId, $authorName, $text);

            $this->di->get("response")->redirectSelf();
        } else if ($this->di->request->getPost('edit-comment-submitted', false) && $user) {
            $id = $this->di->request->getPost('comment-id', null);
            $text = \trim($this->di->request->getPost('comment-text', ''));
            $comments->update($id, $text, function ($comment) use ($user) {
                return $comment['id'] === $user->id;
            });

            $this->di->get("response")->redirectSelf();
        }

        $commentsHTML = $comments->getHtml($id, $user->isUser, $user->isAdmin, $user->name, $user->id);

        $this->renderPage("posts/post", $post->subject, \compact('post', 'user', 'commentsHTML'));
    }

    ..
```



License
------------------

This software carries a MIT license.



```
 .
..:  Copyright (c) 2017 Anders Nygren (litemerafrukt@gmail.com)
```
