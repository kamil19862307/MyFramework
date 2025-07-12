<?php

use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\CommentController;
use MyProject\Controllers\MainController;
use MyProject\Controllers\UserController;

return [
    // Main
    '~^$~' => [MainController::class, 'main'],

    // Articles
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^articles/add$~' => [ArticlesController::class, 'add'],
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'],
    '~^articles/(\d+)/delete$~' => [ArticlesController::class, 'delete'],

    // Comments
    '~^articles/(\d+)/comments$~' => [CommentController::class, 'add'],
    '~^comments/(\d+)/edit$~' => [CommentController::class, 'edit'],

    // Users
    '~^users/register$~' => [UserController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [UserController::class, 'activate'],
    '~^users/login$~' => [UserController::class, 'login'],
    '~^users/logout$~' => [UserController::class, 'logout'],

    // Other routs
    '~^hello/(.*)$~' => [MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [MainController::class, 'sayBye'],

];
