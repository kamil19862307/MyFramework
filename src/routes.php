<?php

use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\MainController;

return [
    '~^$~' => [MainController::class, 'main'],
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^articles/add$~' => [ArticlesController::class, 'add'],
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'],
    '~^hello/(.*)$~' => [MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [MainController::class, 'sayBye'],
];
