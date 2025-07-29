<?php

use MyProject\Controllers\AdminController;
use MyProject\Controllers\ArticleController;
use MyProject\Controllers\CommentController;
use MyProject\Controllers\MainController;
use MyProject\Controllers\UserController;

return [
    // Main
    '~^$~' => [MainController::class, 'main'],

    // Articles
    '~^articles/(\d+)$~' => [ArticleController::class, 'view'],
    '~^articles/add$~' => [ArticleController::class, 'add'],
    '~^articles/(\d+)/edit$~' => [ArticleController::class, 'edit'],
    '~^articles/(\d+)/delete$~' => [ArticleController::class, 'delete'],

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
    '~^admin/users$~' => [UserController::class, 'view'],
    '~^admin/users/(\d+)/edit$~' => [UserController::class, 'edit'],
    '~^admin/users/(\d+)/delete$~' => [UserController::class, 'delete'],
    '~^admin/users/add$~' => [UserController::class, 'add'],


    // Other routs
    '~^hello/(.*)$~' => [MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [MainController::class, 'sayBye'],

];
