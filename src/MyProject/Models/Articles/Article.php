<?php

namespace MyProject\Models\Articles;

use MyProject\Services\Db;

class Article
{
    private int $id;

    private string $name;

    private string $text;

    private int $authorId;

    private string $createdAt;

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);

        $this->$camelCaseName = $value;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getAuthorId(): int
    {
        return $this->authorId;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getText(): string
    {
        return $this->text;
    }

    public static function findAll(): array
    {
        $db = new Db();

        return $db->query(
            'SELECT * FROM `articles`;',
            [],
            Article::class);
    }
    
    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }
}

