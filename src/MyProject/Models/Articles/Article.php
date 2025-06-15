<?php

namespace MyProject\Models\Articles;

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
}

