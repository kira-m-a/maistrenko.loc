<?php

namespace  src\Controllers;

use src\services\Db;

class ArticlesController extends Controller
{
public function index()
    {
        $db = new Db();
        $articles = $db->query('SELECT * FROM `articles`;');
        $this->view->renderHtml('articles/index.php', ['articles' => $articles]);
    }
public function view($id)
    {
        $db = new Db();
        $article = $db->query('SELECT * FROM `articles` WHERE id =:id;', [':id' => $id])[0];
        $this->view->renderHtml('articles/view.php', ['article' => $article]);
    }
}