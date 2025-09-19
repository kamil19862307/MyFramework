<?php
try {
    unset($argv[0]);

    // Автозагрузка
    require __DIR__ . '/../vendor/autoload.php';

    // Переменные окружения
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    // Составляем полное имя класса, добавив нэймспейс
    $className = '\\MyProject\\Cli\\' . array_shift($argv);

    if (!class_exists($className)) {
        throw new \MyProject\Exceptions\CliException('Class "' . $className . '" not found');
    }

    if (!is_subclass_of($className, MyProject\Cli\AbstractCommand::class)) {
        throw new \MyProject\Exceptions\CliException('Class "' . $className . '" not subclass of MyProject\Cli\AbstractCommand');
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