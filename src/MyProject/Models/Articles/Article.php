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
        return User::getById($this->authorId);
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getText(): string
    {
        return $this->text;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }
}

