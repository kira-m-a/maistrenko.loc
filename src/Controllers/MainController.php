<?php

namespace Src\Controllers;

use src\views\View;

class MainController
{
    public $view;
    public $layout = 'default';
    public function __construct()
    {
        $this->view = new View($this->layout);
    }


    public function main()
    {
        $this->view->renderHtml('main/main.php');
    }
    public function sayHello($name)
    {
        echo 'Привет, ' . $name;
    }
}
