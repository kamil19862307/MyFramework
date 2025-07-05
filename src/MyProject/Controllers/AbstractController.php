<?php

namespace MyProject\Controllers;

use MyProject\Models\Users\User;
use MyProject\Models\Users\UsersAuthService;
use MyProject\View\View;

class AbstractController
{
    protected null|User $user;

    protected View $view;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();

        $this->view = new View(__DIR__ . '/../../../templates');

        $this->view->setVar('user', $this->user);
    }

}