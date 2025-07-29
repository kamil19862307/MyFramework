<?php

namespace MyProject\Models\Users;
use MyProject\Exceptions\InvalidArgumentException;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function isConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * @param array $userData
     * @return User
     * @throws InvalidArgumentException
     */
    public static function signUp(array $userData): User
    {
        if (empty($userData['nickname'])) {
            throw new InvalidArgumentException('Не передан nickname');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])){
            throw new InvalidArgumentException(
                'Nickname может состоять только из символов латинского алфавита и цифр'
            );
        }

        if (static::findOneByColumn('nickname', $userData['nickname']) !== null){
            throw new InvalidArgumentException(
                'Пользователь с таким nickname уже существует'
            );
        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException('Email не корректен');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null){
            throw new InvalidArgumentException(
                'Пользователь с таким email уже существует'
            );
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        if (mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException('Password должен быть не менее 8 символов');
        }


        $user = new User();

        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    public function activate(): void
    {
        $this->isConfirmed = true;

        $this->save();
    }

    public static function login(array $loginData): User
    {
        if (empty($loginData['email'])){
            throw new InvalidArgumentException('Не передан Email');
        }

        if (empty($loginData['password'])){
            throw new InvalidArgumentException('Не передан Password');
        }

        $user = User::findOneByColumn('email', $loginData['email']);

        if ($user === null){
            throw new InvalidArgumentException('Пользователя с таким Email не существует');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())){
            throw new InvalidArgumentException('Неправильный пароль');
        }

        if (!$user->isConfirmed()){
            throw new InvalidArgumentException('Пользователь не подтверждён');
        }

        $user->refreshAuthToken();

        $user->save();

        return $user;
    }

    private function refreshAuthToken(): void
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    public function updateFromArray(array $fields): User
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Поле Никнейм не может быть пустым');
        }

        if (empty($fields['role'])) {
            throw new InvalidArgumentException('Поле Роль не может быть пустым');
        }

        $this->setNickname($fields['name']);
        $this->setRole($fields['role']);

        $this->save();

        return $this;
    }
}
