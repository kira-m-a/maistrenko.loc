<?php

namespace src\controllers;

use src\models\User;
use src\exceptions\InvalidArgumentException;
use src\models\UsersAuthService;

class UsersController extends Controller
{
    public function signUp()
    {
        if(!empty($_POST)){
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e){
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
            if($user instanceof User) {
                $this->view->renderHtml('users/signUpSuccess.php');
                return;
            }
        }

        $this->view->renderHtml('users/signUp.php');
    }
    public function login()
    {
        if(!empty($_POST)){
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /IV1-23-1.loc');
                exit();
            } catch (InvalidArgumentException $e){
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }
    public function logout()
    {
        setcookie('token', '', -1, '/', '', false, true);
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}