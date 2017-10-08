Anax postcomments
==================================

[![Latest Stable Version](https://poser.pugx.org/anax/postcomments/v/stable)](https://packagist.org/packages/anax/postcomments)
[![Join the chat at https://gitter.im/mosbth/anax](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/canax?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Build Status](https://travis-ci.org/canax/postcomments.svg?branch=master)](https://travis-ci.org/canax/postcomments)
[![CircleCI](https://circleci.com/gh/canax/postcomments.svg?style=svg)](https://circleci.com/gh/canax/postcomments)
[![Build Status](https://scrutinizer-ci.com/g/canax/postcomments/badges/build.png?b=master)](https://scrutinizer-ci.com/g/canax/postcomments/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/canax/postcomments/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/canax/postcomments/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/canax/postcomments/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/canax/postcomments/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d831fd4c-b7c6-4ff0-9a83-102440af8929/mini.png)](https://insight.sensiolabs.com/projects/d831fd4c-b7c6-4ff0-9a83-102440af8929)

Reddit-like comments to posts.

Uses view-files recursively. There are default view files. If you want to define your own views then look at the included view files for examples. The `Comments` class takes a top level view file as optional parameter.

`CommentsHandler` class needs a simple database class with a query-method. Look at the supplied `Database` class for the interface if you want to build your own. The database needs to be setup with a comments table, se `src/extras` folder for schema. Table name can optionally be set on `CommentsHandler` constructor, defaults to `r1_comments`.

Usage
------------------

Short examples on how to use the module postcomments.



License
------------------

This software carries a MIT license.



```
 .
..:  Copyright (c) 2017 Anders Nygren (litemerafrukt@gmail.com)
```
