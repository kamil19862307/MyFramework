<?php

namespace MyProject\Models\Users;
class User
{
    private string $nickname;

    public function setNickname(string $name): void
    {
        $this->nickname = $name;
    }
    public function getNickname(): string
    {
        return $this->nickname;
    }
}
