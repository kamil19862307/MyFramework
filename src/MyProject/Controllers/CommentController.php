<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthoraizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;
use MyProject\Services\Db;

class CommentController extends AbstractController
{
    public function add(): void
    {
        if ($this->user === null) {
            throw new UnauthoraizedException('Ошибка авторизации');
        }

        if (!empty($_POST)) {
            try {
                $comment = Comment::createFromArray($_POST, $this->user);

            } catch (InvalidArgumentException $exception){
                $this->view->renderHtml('articles/', ['error' => $exception->getMessage()]);
                return;

            } catch (ForbiddenException $exception) {
                $this->view->renderHtml('errors/403.php', ['error' => $exception->getMessage()], 403);
                return;
            }

            header('Location: /articles/' . $comment->getArticleId() . '#comment' . $comment->getId(), true, 302);
            exit();
        }
    }

    public function edit(int $commentId)
    {
        $comment = Comment::getById($commentId);

        if ($comment === null){
            throw new NotFoundException('Нет такого комментария');
        }

        if ($this->user === null){
            throw new UnauthoraizedException('Нет такого пользователя');
        }

        if (!$this->user->isAdmin()){
            throw new ForbiddenException('У вас недостаточно прав');
        }

        if (!empty($_POST)){
            try {
                $comment->updateFromArray($_POST, $this->user);

            } catch (InvalidArgumentException $exception) {
                $this->view->renderHtml('comments/edit.php',
                    ['error' => $exception->getMessage(), 'comment' => $comment]);

                return;
            }

            header('Location: /articles/' . $comment->getArticleId() . '#comment' . $comment->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('comments/edit.php', ['comment' => $comment]);
    }
}