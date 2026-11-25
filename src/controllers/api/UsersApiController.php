<?php

namespace src\controllers\api;

use src\models\User;
use src\exceptions\InvalidArgumentException;

class UsersApiController extends ApiController
{
    public function user()
    {
        if ($this->user !== null) {
            $this->view->displayJson([
                'user'   => $this->user->getNickname(),
                'userId' => $this->user->getId()
            ]);
        } else {
            $this->view->displayJson(['user' => 'No authenticated']);
        }
    }

    public function auth()
{
    if ($this->user === null) {
        throw new \src\exceptions\UnauthorizedException('Требуется авторизация');
    }

    $backUrl = $_GET['back'] ?? '/IV1-23-1.loc/web/basic_auth.html';
    header('Location: ' . $backUrl);
    exit;
}

    public function login()
    {
        $input = $this->getInputData();

        try {
            $user = User::login($input);
            $this->view->displayJson([
                'user'   => $user->getNickname(),
                'userId' => $user->getId()
            ]);
        } catch (InvalidArgumentException $e) {
            $this->view->displayJson([
                'user'  => 'No authenticated',
                'error' => $e->getMessage()
            ], 401);
        }
    }
}
