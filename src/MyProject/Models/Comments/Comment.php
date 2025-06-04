<?php

namespace MyProject\Models\Comments;

class Comment
{
    public function __construct(private int $comments)
    {
    }

    public function getComments(): int
    {
        return $this->comments;
    }

    public function setComments(int $comments): void
    {
        $this->comments = $comments;
    }
}
