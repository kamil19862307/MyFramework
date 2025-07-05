<?php

use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\MainController;
use MyProject\Controllers\UserController;

return [
    '~^$~' => [MainController::class, 'main'],
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^articles/add$~' => [ArticlesController::class, 'add'],
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'],
    '~^articles/(\d+)/delete$~' => [ArticlesController::class, 'delete'],
    '~^hello/(.*)$~' => [MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [MainController::class, 'sayBye'],
    '~^users/register$~' => [UserController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [UserController::class, 'activate'],
    '~^users/login$~' => [UserController::class, 'login'],
    '~^users/logout$~' => [UserController::class, 'logout'],

];
