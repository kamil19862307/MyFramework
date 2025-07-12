<?php

namespace MyProject\Models\Comments;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Comment extends ActiveRecordEntity
{
    protected int $authorId;

    protected int $articleId;

    protected string $text;

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getText(): string
    {
        return $this->text;
    }
    
    public function setAuthor(User $user): void
    {
        $this->authorId = $user->getId();
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
    
    protected static function getTableName(): string
    {
        return 'comments';
    }

    public static function createFromArray(array $fields, User $user): Comment
    {
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Текст статьи не может быть пустым');
        }

        $comment = new Comment();

        $comment->setAuthor($user);
        $comment->setArticleId($fields['article_id']);
        $comment->setText($fields['text']);

        $comment->save();

        return $comment;
    }

    public function updateFromArray(array $fields): Comment
    {
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Текст статьи не может быть пустым');
        }

       $this->setText($fields['text']);

        $this->save();

        return $this;
    }
}
