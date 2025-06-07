<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Services\Db;
use MyProject\View\View;

class MainController
{
    public function __construct(
        private $view = new View(__DIR__ . '/../../../templates'),
    )
    {
    }

    public function main(): void
    {
        $title = 'Главная';

        $articles = Article::findAll();

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