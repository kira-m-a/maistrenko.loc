<?php

namespace src\Controllers;
use src\views\View;

class Controller
{
public $view;
    public $layout = 'default';
    public function __construct()
    {
        $this->view = new View($this->layout);
    }
}