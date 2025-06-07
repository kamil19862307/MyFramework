<?php

use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\MainController;

return [
    '~^$~' => [MainController::class, 'main'],
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^hello/(.*)$~' => [MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [MainController::class, 'sayBye'],
];
