<?php

namespace MyProject\Models\Articles;

use MyProject\Models\Comments\Comment;
use MyProject\Models\Users\User;
class Article
{
    public function __construct(private string $title,private string $text, private User $author, private Comment $comments)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function getText(): string
    {
        return $this->text;
    }
    public function getUser(): User
    {
        return $this->author;
    }

    public function getComments(): Comment
    {
        return $this->comments;
    }
}

