<?php

namespace src\models;
use src\models\Users;
class UsersAuthService
{
    public static function createToken(Users $user){
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, 0, '/' ,'', false, true);
    }
    public static function getUserByToken(): ? Users{
    $token = $_COOKIE['token'] ?? '';
    if (empty($token)){
        return null;
    }
    [$userId, $authToken] = explode(':', $token, 2);
    $user = Users::getById((int)$userId);
    if ($user === null){
        return null;
    }
    if($user->getAuthToken() !== $authToken){
        return null;
    }
    return $user;
     
    }
}