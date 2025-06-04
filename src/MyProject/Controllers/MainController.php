<?php

namespace MyProject\Controllers;

use MyProject\Services\Db;
use MyProject\View\View;

class MainController
{
    public function __construct(
        private $view = new View(__DIR__ . '/../../../templates'),
        private $db = new Db(),
    )
    {
    }

    public function main(): void
    {
        $title = 'Главная';

        $articles = $this->db->query('SELECT `name`, `text` FROM `articles`;');

        $this->view->renderHtml('main/main.php', ['title' => $title, 'articles' => $articles]);
    }

    public function sayHello(string $name): void
    {
        $title = 'Страница приветствия';

        $this->view->renderHtml('main/hello.php', ['title' => $title, 'name' => $name]);
    }

    public function sayBye(string $name): void
    {
        echo 'Пока, ' . $name . '!';
    }
}