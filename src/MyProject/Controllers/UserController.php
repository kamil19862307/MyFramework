<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Models\Users\UsersAuthService;
use MyProject\Services\Db;
use MyProject\Services\EmailSender;
use MyProject\View\View;

class UserController extends AbstractController
{
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