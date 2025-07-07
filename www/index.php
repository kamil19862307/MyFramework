<?php

use MyProject\Exceptions\DbException;
use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthoraizedException;
use MyProject\View\View;

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
        throw new NotFoundException('Страница отсутствует');
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();

    $controller->$actionName(...$matches);

} catch (DbException $exception) {

    $view = new View(__DIR__ . '/../templates/errors');

    $view->renderHtml('500.php', ['error' => $exception->getMessage()], 500);

} catch (NotFoundException $exception) {

    $view = new View(__DIR__ . '/../templates/errors');

    $view->renderHtml('404.php', ['error' => $exception->getMessage()], 404);

} catch (UnauthoraizedException $exception) {

    $view = new View( __DIR__ . '/../templates/errors');

    $view->renderHtml('401.php', ['error' => $exception->getMessage()], 401);

}
