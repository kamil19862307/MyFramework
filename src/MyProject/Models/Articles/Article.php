<?php

namespace MyProject\Models\Articles;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

class Article extends ActiveRecordEntity
{
    protected string $name;

    protected string $text;

    protected int $authorId;

    public function getAuthorId(): int
    {
        return (int) $this->authorId;
    }

    public function getAuthor(): User
    {
        return User::getById($this->getAuthorId());
    }

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }

    public static function createFromArray(array $fields, User $user): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Название статьи не может быть пустым');
        }

        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Текст статьи не может быть пустым');
        }

        if (!$user->isAdmin()) {
            throw new ForbiddenException('Недостаточно прав');
        }

        $article = new Article();

        $article->setAuthor($user);
        $article->setName($fields['name']);
        $article->setText($fields['text']);

        $article->save();

        return $article;
    }

    public function updateFromArray(array $fields): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Название статьи не может быть пустым');
        }

        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Текст статьи не может быть пустым');
        }

        $this->setName($fields['name']);
        $this->setText($fields['text']);

        $this->save();

        return $this;
    }
}

