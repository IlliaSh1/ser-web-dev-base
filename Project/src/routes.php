<?php 

return [
    
    '~hello/(.*)~' => [Controllers\MainController::class, 'sayHello'],
    '~bye/(.*)~' => [Controllers\MainController::class, 'sayBye'],
    // NOT FOUND
    '~^$~' => [Controllers\MainController::class, 'main'],
    // Articles
    '~article/show/(\d+)~' => [Controllers\ArticleController::class, 'show'],
    '~article/create~' => [Controllers\ArticleController::class, 'create'],
    '~article/store~' => [Controllers\ArticleController::class, 'store'],
    '~article/edit/(\d+)~' => [Controllers\ArticleController::class, 'edit'],
    '~article/update/(\d+)~' => [Controllers\ArticleController::class, 'update'],
    '~article/delete/(\d+)~' => [Controllers\ArticleController::class, 'delete'],
    // Comments
    // '~article/(\d+)/comments~' => [Controllers\CommentController::class, 'comments'],
    '~article/(\d+)/comment/store~' => [Controllers\CommentController::class, 'store'],
    '~comment/edit/(\d+)~' => [Controllers\CommentController::class, 'edit'],
    '~comment/update/(\d+)~' => [Controllers\CommentController::class, 'update'],
    '~comment/delete/(\d+)~' => [Controllers\CommentController::class, 'delete'],
];