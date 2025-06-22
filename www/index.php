<?php

try {

    require __DIR__ . '/../vendor/autoload.php';

    $route = $_GET['route'] ?? '';

    $routes = require __DIR__ . '/../src/routes.php';

    $isRouteFound = false;

    foreach ($routes as $pattern => $controllerAndAction) {

        preg_match($pattern, $route, $matches);

        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \MyProject\Exceptions\NotFoundException('Страница отсутствует');
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();

    $controller->$actionName(...$matches);

} catch (\MyProject\Exceptions\DbException $exception) {

    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');

    $view->renderHtml('500.php', ['error' => $exception->getMessage()], 500);

} catch (\MyProject\Exceptions\NotFoundException $exception) {

    $view = new \MyProject\View\View(__DIR__ . '/../templates/errors');

    $view->renderHtml('404.php', ['error' => $exception->getMessage()], 404);
}
