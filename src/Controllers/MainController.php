<?php

namespace Src\Controllers;

use src\services\Db;


class MainController extends Controller
{
    


    public function main()
    {
        $db = new Db();
        $articles = $db->query('SELECT * FROM `articles`;');
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }
    public function sayHello($name)
    {
        echo 'Привет, ' . $name;
    }
}
