<?php

namespace Src\Controllers;

use src\views\View;
use src\services\Db;
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
        $this->view->setVar('user',$this->user);
    }
    public function main(){
        
        $db = new Db();
        $articles = $db->query("SELECT * FROM `articles`;");
        
    $this->view->renderHtml('main/main.php', ['articles'=> $articles]);
    
    }
    }

