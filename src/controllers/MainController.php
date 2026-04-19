<?php

namespace Src\Controllers;
use  src\views\View;
use src\services\Db;

class MainController extends Controller
{
    public $view;
    public $layout = 'default';
   
    public function main()
    {
       $db = Db::getInstance();
        $articles = $db->query('SELECT * FROM `articles`;');
        
    $this->view->renderHtml('main/main.php', ['articles'=> $articles]);
    }

    public function sayHello($name)
    {
        echo 'Привет, ' . $name;
    }
}