<?php

use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\MainController;

return [
    '~^$~' => [MainController::class, 'main'],
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^articles/insert$~' => [ArticlesController::class, 'insert'],
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'],
    '~^hello/(.*)$~' => [MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [MainController::class, 'sayBye'],
];
