<?php

namespace MyProject\Controllers;

use Exception;
use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthoraizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UsersAuthService;
use MyProject\Services\Db;
use MyProject\View\View;

class ArticleController extends AbstractController
{
    public function view(int $articleId): void
    {
        $isAdmin = false;

        $article = Article::getById($articleId);

        $comments = Comment::findAllByColumn('article_id', $articleId);

        if ($article === null) {
            throw new NotFoundException('Статья удалена либо не существовала');
        }

        if ($comments === null) {
            $comments = 'Пока нет комментариев';
        }

        if ($this->user !== null) {
            $isAdmin = $this->user->isAdmin();
        }

        $this->view->renderHtml('articles/view.php',
            [
                'article' => $article,
                'comments' => $comments,
                'isAdmin' => $isAdmin
            ]);
    }

    public function add(): void
    {
        if ($this->user === null) {
            throw new UnauthoraizedException('Ошибка авторизации');
        }

        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);

            } catch (InvalidArgumentException $exception){
                $this->view->renderHtml('articles/add.php', ['error' => $exception->getMessage()]);
                return;

            } catch (ForbiddenException $exception) {
                $this->view->renderHtml('errors/403.php', ['error' => $exception->getMessage()], 403);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/add.php');
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException('Не могу найти такую статью');
        }

        if ($this->user === null) {
            throw new UnauthoraizedException('Нет такого пользовавтеля');
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Упс, Недостаточно прав');
        }

        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);

            } catch (InvalidArgumentException $exception) {
                $this->view->renderHtml('articles/edit.php',
                    ['error' => $exception->getMessage(), 'article' => $article]);

                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    public function delete(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', ['error' => 'Нет такой статьи'], 404);
            return;
        }

        // Also delete comments that relate to the article
        while ($comment = Comment::findOneByColumn('article_id', $articleId)) {
            $comment->delete();
        }

        $article->delete();

        header('Location: /', true, 302);

        exit();
    }
}