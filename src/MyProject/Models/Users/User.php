<?php

namespace MyProject\Models\Users;
use MyProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    protected string $nickname;

    protected string $email;

    protected int $isConfirmed;

    protected string $role;

    protected string $passwordHash;

    protected string $authToken;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $name): void
    {
        $this->nickname = $name;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}
