--
-- Table comments
--
DROP TABLE IF EXISTS r1_comments;
CREATE TABLE r1_comments (
    `id`          INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `postId`      INT NOT NULL,
    `parentId`    INT DEFAULT 0,
    `authorId`    INT NOT NULL,
    `authorName`  VARCHAR(100) DEFAULT 'unknown',
    `text`        TEXT NOT NULL,
    `created`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated`     DATETIME DEFAULT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

ALTER TABLE r1_comments AUTO_INCREMENT=1;

--
-- Example comments
--
INSERT INTO r1_comments
  (postId, parentId, authorId, authorName,`text`)
VALUES
  (2, 0, 3, 'litemerafrukt', 'whatever'),
  (3, 0, 1, 'admin', 'whatnot???'),
  (3, 2, 4, 'deadjoe', 'hear hear'),
  (2, 0, 4, 'deadjoe', 'chim in')
;

select * from r1_comments;
