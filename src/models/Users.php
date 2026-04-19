<?php

namespace src\models;

use src\exceptions\InvalidArgumentException;
use src\services\Db;

class Users extends ActiveRecordEntity
{

    protected $id;
    protected $nickname;
    protected $email;
    protected $is_confirmed;
    protected $password_hash;
    protected $created_at;
    protected $role;
    protected $authtoken;



    public function getNickname(): string
    {
        return $this->nickname;
    }
    public function getAuthToken()
    {
        return $this->authtoken;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): int
    {
        return $this->id;
    }
    // public static function getById($id): ?self{
    //  $db = Db::getInstance();
    // $entities = $db->query('SELECT * FROM `users` WHERE id = :id;',[':id'=>$id], static::class);
    // return $entities ? $entities[0] : null;
    // }
    protected static function getTableName(): string
    {
        return 'users';
    }
    public  function getPasswordHash(): string
    {
        return $this->password_hash;
    }
    public static function signUp(array $userData)
    {
        if (empty($userData['nickname'])) {
            throw new InvalidArgumentException('Не передан логин');
        }
        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }
        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Не передан пароль');
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidArgumentException('Только латиница и цифры ');
        }
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Некорректный email ');
        }
        if (mb_strlen($userData['password']) < 7) {
            throw new InvalidArgumentException('Пароль не меньше 8 символов');
        }
        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким Email уже есть');
        }
        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким логином уже есть');
        }
        $user  = new Users();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->password_hash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->role = 'user';
        $user->authtoken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();
        return $user;
    }
    public function refreshAuthToken()
    {
        $this->authtoken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }
    public static function login(array $loginData)
    {

        if (empty($loginData['nickname'])) {
            throw new InvalidArgumentException('Не передан логин');
        }
        if (empty($loginData['password'])) {
            throw new InvalidArgumentException('Не передан пароль');
        }
        $user = Users::findOneByColumn('nickname', $loginData['nickname']);
        if ($user === null) {
            throw new InvalidArgumentException('Неправильный логин или пароль');
        }
        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Неправильный логин или пароль');
        }
        $user->refreshAuthToken();
        $user->save();
        return  $user;
    }
}
