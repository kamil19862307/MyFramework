<?php
try {
    unset($argv[0]);

    // Автозагрузка
    require __DIR__ . '/../vendor/autoload.php';

    // Составляем полное имя класса, добавив нэймспейс
    $className = '\\MyProject\\Cli\\' . array_shift($argv);

    if (!class_exists($className)) {
        throw new \MyProject\Exceptions\CliException('Class "' . $className . '" not found');
    }

    $params = [];

    foreach ($argv as $argument) {
        preg_match('/^-(.+)=(.+)$/', $argument, $matches);

        if (!empty($matches)) {
            $paramName = $matches[1];
            $paramValue = $matches[2];

            $params[$paramName] = $paramValue;
        }
    }

    // Создаём экземпляр класса, передав параметры и вызываем метод execute()
    $class = new $className($params);

    $class->execute();

} catch (\MyProject\Exceptions\CliException $exception) {
    echo 'Error ' . $exception->getMessage();
}