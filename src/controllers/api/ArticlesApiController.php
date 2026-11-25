<?php

namespace src\controllers\api;

use src\models\Article;
use src\exceptions\NotFoundException;
use src\exceptions\UnauthorizedException;
use src\exceptions\ForbiddenException;

class ArticlesApiController extends ApiController
{
    public function all()
    {
        $articles = Article::findAll();
        $result = [];

        foreach ($articles as $article) {
            $result[] = [
                'id'       => $article->getId(),
                'name'     => $article->getName(),
                'text'     => $article->getText(),
                'img'      => $article->getImg(),
                'authorId' => $article->getAuthorId(),
            ];
        }

        $this->view->displayJson(['articles' => $result]);
    }

    public function view($id)
    {
        $article = Article::getById($id);
        if ($article !== null) {
            $this->view->displayJson([
                'article' => [
                    'id'       => $article->getId(),
                    'name'     => $article->getName(),
                    'text'     => $article->getText(),
                    'img'      => $article->getImg(),
                    'authorId' => $article->getAuthorId(),
                ]
            ]);
        } else {
            throw new NotFoundException();
        }
    }

    public function add()
    {
        if ($this->user === null) {
            throw new UnauthorizedException('Необходима авторизация');
        }

        $input = $this->getInputData();

        if (empty($input['article']) || empty($input['article']['name'])) {
            $this->view->displayJson(['error' => 'Заполните обязательные поля статьи'], 400);
            return;
        }

        try {
            $article = Article::create($input['article'], ['size' => 0], $this->user);

            $this->view->displayJson([
                'result' => 'ok',
                'article' => [
                    'id'       => $article->getId(),
                    'name'     => $article->getName(),
                    'text'     => $article->getText(),
                    'img'      => $article->getImg(),
                    'authorId' => $article->getAuthorId()
                ]
            ], 201);
        } catch (\Exception $e) {
            $this->view->displayJson(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        if ($this->user === null) {
            throw new UnauthorizedException('Необходима авторизация');
        }

        $article = Article::getById($id);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }

        if ($article->getAuthorId() !== $this->user->getId()) {
            throw new ForbiddenException('Вы можете редактировать только свои статьи');
        }

        $input = $this->getInputData();
        $articleData = $input['article'] ?? null;

        if (empty($articleData) || empty($articleData['name'])) {
            $this->view->displayJson(['success' => false, 'error' => 'Название обязательно'], 400);
            return;
        }

        try {
            $article->updateFromArray($articleData);

            $this->view->displayJson([
                'success' => true,
                'article' => [
                    'id'       => $article->getId(),
                    'name'     => $article->getName(),
                    'text'     => $article->getText(),
                    'img'      => $article->getImg(),
                    'authorId' => $article->getAuthorId()
                ]
            ]);
        } catch (\Exception $e) {
            $this->view->displayJson(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function delete($id)
    {
        if ($this->user === null) {
            throw new UnauthorizedException('Необходима авторизация');
        }

        $article = Article::getById($id);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }

        if ($article->getAuthorId() !== $this->user->getId()) {
            throw new ForbiddenException('Вы можете удалять только свои статьи');
        }

        $article->delete();
        $this->view->displayJson(['success' => true]);
    }
}
