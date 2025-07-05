<?php

namespace MyProject\Controllers;

use Exception;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UsersAuthService;
use MyProject\Services\Db;
use MyProject\View\View;

class ArticlesController extends AbstractController
{
    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException('Статья удалена либо не существовала');
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

    public function delete(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $article->delete();

        var_dump($article);
    }
}