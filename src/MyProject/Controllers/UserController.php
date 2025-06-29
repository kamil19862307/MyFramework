<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Services\Db;
use MyProject\Services\EmailSender;
use MyProject\View\View;

class UserController
{
    /**
     * @var string view
     */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
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

            if ($user instanceof User){
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

        if ($isCodeValid){
            $user->activate();

            // Если активация прошла успешно, удаляем код из базы
            UserActivationService::deleteActivationCode($user_id);

            $this->view->renderHtml('users/activationSuccessfull.php', );
        }
    }
}