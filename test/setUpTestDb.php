<?php

use litemerafrukt\Database\Database;

function setUpTestDb()
{
    $db = new Database('sqlite::memory:');

    $db->query('DROP TABLE IF EXISTS r1_posts');
    $db->query("CREATE TABLE r1_posts (
        `id`            INTEGER PRIMARY KEY,
        `subject`       VARCHAR(100) NOT NULL,
        `author`        VARCHAR(100) NOT NULL,
        `authorId`      INT NOT NULL,
        `authorEmail`   VARCHAR(100) NOT NULL,
        `rawText`       TEXT NOT NULL,
        `created`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated`       DATETIME DEFAULT NULL
    )");

    $db->query("INSERT INTO r1_posts
      (subject, author, authorId, authorEmail, rawText)
    VALUES
      ('First!', 'litemerafrukt', 3, 'litemerafrukt@gmail.com', 'Direkt från `setup-db.sql`!'),
      ('Second', 'doe', 2, 'jane@doe.io', 'with two comments'),
      ('Third', 'admin', 2, 'admin@admin.io', 'with comment to a comment')");

    $db->query('DROP TABLE IF EXISTS r1_comments');
    $db->query("CREATE TABLE r1_comments (
        `id`          INTEGER PRIMARY KEY,
        `postId`      INT NOT NULL,
        `parentId`    INT DEFAULT 0,
        `authorId`    INT NOT NULL,
        `authorName`  VARCHAR(100) DEFAULT 'unknown',
        `text`        TEXT NOT NULL,
        `created`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated`     DATETIME DEFAULT NULL
    )");

    $db->query("INSERT INTO r1_comments
      (postId, parentId, authorId, authorName,`text`)
    VALUES
      (2, 0, 3, 'litemerafrukt', 'whatever'),
      (3, 0, 1, 'admin', 'whatnot???'),
      (3, 2, 4, 'deadjoe', 'hear hear'),
      (2, 0, 4, 'deadjoe', 'chim in')
    ");

    return $db;
}
