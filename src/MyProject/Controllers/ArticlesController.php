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
        private $db = new Db(),
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
//
//        $articleAuthor = User::getById($article->getAuthorId());
//
//        if ($articleAuthor === null) {
//            $articleAuthor = new User();
//            $articleAuthor->setNickname('Аноним');
//        }

        $this->view->renderHtml('articles/view.php', ['article' => $article]);
    }
}