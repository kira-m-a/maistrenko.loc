<?php

namespace src\controllers;
use src\views\View;
use src\models\UsersAuthService;
class Controller
{
    public $view;
    protected $user;
    public $layout = 'default';
    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View($this->layout);
        $this->view->setVar('user', $this->user);
    }

    public function getInputData(){
        return json_decode(file_get_contents('php://input'), true);
    }
}