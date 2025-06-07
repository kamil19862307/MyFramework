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
        $article = $this->db->query(
            'SELECT `author_id`, `name`, `text` FROM `articles` WHERE `id` = :id;',
            ['id' => $articleId],
            Article::class
        );

        if ($article === []) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $authorId = $article[0]->getAuthorId();

        $authorName = $this->db->query(
            'SELECT `nickname` FROM `users` WHERE `id` = :id;',
            ['id' => $authorId],
            User::class
        );

        if ($authorName === []) {
            $user = new User();
            $user->setNickname('Аноним');
            $authorName[0] = $user;
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article[0], 'author' => $authorName[0]]);
    }
}