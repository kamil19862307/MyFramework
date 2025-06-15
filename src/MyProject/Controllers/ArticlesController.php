<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\Db;
use MyProject\View\View;

class ArticlesController
{
    public function __construct(
        private $view = new View(__DIR__ . '/../../../templates'),
    )
    {
    }

    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article]);
    }

    public function insert()
    {

    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $article->setName('Новое назвавние Статьи 2');
        $article->setText('Новое назвавние Текста 2');

        $article->save();
//        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }
}