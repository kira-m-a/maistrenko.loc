<?php

namespace Src\Controllers;

use src\models\Articles;
use src\models\Users;
use src\models\UsersAuthService;
// use src\services\Db;
use src\exceptions\NotFoundException;
use src\exceptions\UnauthorizedException;
use src\exceptions\InvalidArgumentException;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Articles::findAll();
        $this->view->renderHtml('articles/index.php', ['articles' => $articles]);
    }
    public function view($id)
    {
        $article = Articles::getById($id);
        if ($article !== null) {
            $this->view->renderHtml('articles/view.php', ['article' => $article]);
        } else {
            throw new NotFoundException();
        }
    }
    public function edit($id)
    {
        $article = Articles::getById($id);
        if ($article === null) {
            throw new UnauthorizedException();
        }
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST, $_FILES['img'], $this->user);
                header("Location: /maistrenko.loc/article/{$article->getId()}");
                exit;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }
    public function delete($id)
    {
        $article = Articles::getById($id);
        if ($article === null) {
            throw new UnauthorizedException();
        }
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        $article->delete();
        header("Location: /maistrenko.loc/articles");
        exit;
    }
    public function add()
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $article = Articles::create($_POST, $_FILES['img'], $this->user);
                header("Location: /maistrenko.loc/article/{$article->getId()}");
                exit;
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('articles/add.php');
    }
    public function search()
    {
        if (empty($_GET['q'])) {
            $this->view->renderHtml('articles/search.php');
            return;
        } else {
            $articles = Articles::searchByName($_GET['q']);
            $this->view->renderHtml('articles/search.php', ['articles' => $articles]);
        }
    }
}
