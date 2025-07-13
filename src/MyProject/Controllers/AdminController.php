<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Models\Articles\Article;

class AdminController extends AbstractController
{
    public function main()
    {
        $title = 'Админ панель';

        if(!$this->user->isAdmin()) {
            throw new ForbiddenException('Только Администраторы могут сюда попасть');
        }

        $this->view->renderHtml('admin/main.php', [
            'title' => $title,
            'user' => $this->user
        ]);
    }

    public function articles()
    {
        $title = 'Админ панель -> статьи';

        $articles = Article::findAll();

        $this->view->renderHtml('admin/articles.php', [
            'title' => $title,
            'articles' => $articles,
            'user' => $this->user
        ]);
    }
}