<?php

use MyProject\Controllers\AdminController;
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
    '~^comments/(\d+)/delete$~' => [CommentController::class, 'delete'],


    // Users
    '~^users/register$~' => [UserController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [UserController::class, 'activate'],
    '~^users/login$~' => [UserController::class, 'login'],
    '~^users/logout$~' => [UserController::class, 'logout'],

    // Admin
    '~^admin$~' => [AdminController::class, 'main'],
    '~^admin/articles/$~' => [AdminController::class, 'articles'],
    '~^admin/comments/$~' => [AdminController::class, 'comments'],
    '~^admin/users/$~' => [AdminController::class, 'users'],


    // Other routs
    '~^hello/(.*)$~' => [MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [MainController::class, 'sayBye'],

];
