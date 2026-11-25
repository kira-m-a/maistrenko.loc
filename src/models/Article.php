<?php
namespace src\models;

use InvalidArgumentException;
use src\services\Db;

class Article extends ActiveRecordEntity
{
    protected $author_id;
    protected $name;
    protected $text;
    protected $created_at;
    protected $img = null;

    protected static function getTableName(): string
    {
        return 'articles';
    }
    public function getAuthorId(): int
    {
        return $this->author_id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getText(): string
    {
        return $this->text;
    }
    public function getImg(): ?string
    {
        return $this->img;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setText($text)
    {
        $this->text = $text;
    }
    public function setAuthorId($authorId)
    {
        $this->author_id = $authorId;
    }

    public function getAuthor(): User
    {
        return User::getById($this->author_id);
    }

    public static function create(array $fields, array $unusedMeta, User $author): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $article = new Article();
        $article->name = $fields['name'];
        $article->text = $fields['text'];
        $article->author_id = $author->getId();

        if (!empty($fields['img'])) {
            $base64String = $fields['img'];

            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                $extension = strtolower($type[1]);
                
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    throw new InvalidArgumentException('Недопустимый формат изображения');
                }

                $data = substr($base64String, strpos($base64String, ',') + 1);
                $decodedData = base64_decode($data);

                if ($decodedData === false) {
                    throw new InvalidArgumentException('Ошибка декодирования изображения');
                }

                if (strlen($decodedData) > 10 * 1024 * 1024) {
                    throw new InvalidArgumentException('Слишком большой файл! Должно быть не более 10МБ');
                }

                $fileName = uniqid('img_', true) . '.' . $extension;
                $filePath = 'uploads/' . $fileName;

                if (!is_dir('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                if (file_put_contents($filePath, $decodedData) === false) {
                    throw new InvalidArgumentException('Ошибка при сохранении файла на сервер');
                }

                $article->img = $filePath;
            } else {
                throw new InvalidArgumentException('Неверный формат Base64 строки');
            }
        }

        $article->save();
        return $article;
    }

    public function updateFromArray(array $fields, array $unusedMeta = []): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $this->name = $fields['name'];
        $this->text = $fields['text'];

        if (!empty($fields['img'])) {
            $base64String = $fields['img'];

            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                $extension = strtolower($type[1]);
                
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    throw new InvalidArgumentException('Недопустимый формат изображения');
                }

                $data = substr($base64String, strpos($base64String, ',') + 1);
                $decodedData = base64_decode($data);

                if ($decodedData === false) {
                    throw new InvalidArgumentException('Ошибка декодирования изображения');
                }

                if (strlen($decodedData) > 10 * 1024 * 1024) {
                    throw new InvalidArgumentException('Слишком большой файл! Должно быть не более 10МБ');
                }

                if (!empty($this->img) && file_exists($this->img)) {
                    unlink($this->img);
                }

                $fileName = uniqid('img_', true) . '.' . $extension;
                $filePath = 'uploads/' . $fileName;

                if (!is_dir('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                if (file_put_contents($filePath, $decodedData) === false) {
                    throw new InvalidArgumentException('Ошибка при сохранении файла на сервер');
                }

                $this->img = $filePath;
            }
        }

        $this->save();
        return $this;
    }

    public static function searchByName(string $searchString): ?array
    {
        return parent::search('name', $searchString);
    }
}
