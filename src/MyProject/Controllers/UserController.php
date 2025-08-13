<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Models\Users\UsersAuthService;
use MyProject\Services\Db;
use MyProject\Services\EmailSender;
use MyProject\Services\ImageUploader;
use MyProject\View\View;

class UserController extends AbstractController
{
    public function view(): void
    {
        $title = 'Все пользовелели';

        $users = User::findAll();

        $this->view->renderHtml('admin/users.php', ['title' => $title, 'users' => $users]);
    }

    public function add()
    {
        $title = 'Создание пользователя';

        if (!empty($_POST)) {
            try {
                User::signUp($_POST);

                header('Location: /admin/users', true, 302);
                exit();

            } catch (InvalidArgumentException $exception) {
                $this->view->renderHtml('admin/users/add.php', [
                    'title' => $this,
                    'error' => $exception->getMessage()
                ]);
            }
        }

        $this->view->renderHtml('admin/users/add.php', ['title' => $title]);
    }

    public function edit(int $userId): void
    {
        $title = 'Редактирование пользователя';

        $user = User::getById($userId);



        if (!empty($_POST)) {
            try {
                $user->updateFromArray($_POST);

                // Загружаем картинку
                if (!empty($_FILES['avatar'])) {
                    $file = $_FILES['avatar'];

                    $uploader = new ImageUploader(__DIR__ . '/../../../www/uploads/');

                    $fileName = $uploader->upload($file);
                }

                header('Location: /admin/users', true, 302);
                exit();

            } catch (InvalidArgumentException $exception) {
                $this->view->renderHtml('admin/users/edit.php', [
                    'error' => $exception->getMessage(),
                    'user' => $user
                ]);

                return;
            }
        }

        $this->view->renderHtml('admin/users/edit.php', ['title' => $title, 'user' => $user]);
    }

    public function delete(int $userId)
    {
        $user = User::getById($userId);

        if ($user === null) {

            $this->view->renderHtml('errors/404.php', ['error' => 'Нет такого пользователя'], 404);

            return;
        }

        if ($user->getId() === $this->user->getId()) {
            throw new ForbiddenException('Невозможно удалить самого себя');
        }

        if ($user->isAdmin()) {
            throw new ForbiddenException('Невозможно удалить администтратора');
        }


        $user->delete();

        header('Location: /admin/users', true, 302);

        exit();
    }
    
    public function signUp(): void
    {
        $title = 'Регистрация нового пользователя';

        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);

            } catch (InvalidArgumentException $exception) {
                $this->view->renderHtml(
                    'users/signUp.php',
                    ['title' => $title, 'error' => $exception->getMessage()]
                );
                return;
            }

            if ($user instanceof User) {
                $title = 'Регистрация успешна!';

                // Помещаем в таблицу код активации и его же возвращаем
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация', 'userActivation.php', [
                    'user_id' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderHtml('users/signUpSuccessfull.php', ['title' => $title]);

                return;
            }
        }


        $this->view->renderHtml('users/signUp.php', ['title' => $title]);

    }

    public function activate(int $user_id, string $activationCode): void
    {
        $user = User::getById($user_id);

        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);

        if ($isCodeValid) {
            $user->activate();

            // Если активация прошла успешно, удаляем код из базы
            UserActivationService::deleteActivationCode($user_id);

            $this->view->renderHtml('users/activationSuccessfull.php',);

        } else {
            $error = 'Код активации не совпадает или не найден.';

            $this->view->renderHtml('errors/404.php', ['error' => $error]);
        }
    }

    public function login(): void
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);

                UsersAuthService::createToken($user);

                if ($user->isAdmin()) {
                    header('Location: /admin');

                    exit();
                }

                header('Location: /');

                exit();

            } catch (InvalidArgumentException $exception) {
                $this->view->renderHtml('users/login.php', ['error' => $exception->getMessage()]);

                return;
            }
        }

        $this->view->renderHtml('users/login.php');
    }

    public function logOut(): void
    {
        if (isset($_COOKIE['token'])) {
            setcookie('token', '', -1, '/', false, true);

            header('Location: /');
        }

        return;
    }
}