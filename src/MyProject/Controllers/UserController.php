<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
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

                $this->view->renderHtml('users/signUpSuccessfull.php', ['title' => $title]);

                return;
            }
        }


        $this->view->renderHtml('users/signUp.php', ['title' => $title]);

    }
}