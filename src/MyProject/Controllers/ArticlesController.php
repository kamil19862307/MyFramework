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

    public function add()
    {
        $article = new Article();

        $author = User::getById(1);

        $article->setAuthor($author);
        $article->setName('Новое назвавние Статьи');
        $article->setText('Новое назвавние Текста');

        $article->save();

        echo '<pre>';
        var_dump($article);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $article->setName('Новое назвавние Статьи 10');
        $article->setText('Новое назвавние Текста 10');

        $article->save();
//        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }
}