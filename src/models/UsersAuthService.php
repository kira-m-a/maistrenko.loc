<?php

namespace src\models;

class UsersAuthService
{
    public static function createToken(User $user): void
    {
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, 0, '/', '', false, true);
    }

    public static function getUserByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);

        $user = User::getById((int) $userId);

        if ($user === null) {
            return null;
        }

        if ($user->getAuthToken() !== $authToken) {
            return null;
        }

        return $user;
    }

    public static function getUserByAuthBasic(): ?User
{
    $login = null;
    $password = null;

    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] 
        ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] 
        ?? null;

    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
        $login = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
    } elseif (!empty($authHeader) && stripos($authHeader, 'Basic ') === 0) {
        $base64 = substr($authHeader, 6);
        $decoded = base64_decode($base64);
        if ($decoded !== false && strpos($decoded, ':') !== false) {
            [$login, $password] = explode(':', $decoded, 2);
        }
    }

    if ($login === null || $password === null) {
        return null;
    }

    $user = User::findOneByColumn('nickname', $login);
    if ($user === null || !password_verify($password, $user->getPasswordHash())) {
        return null;
    }

    return $user;
}


public static function getUserByApiToken(): ?User
{
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';

    if (!preg_match('/^Bearer\s+(.+)$/i', $authHeader, $matches)) {
        return null;
    }

    $token = trim($matches[1]);
    if (empty($token)) {
        return null;
    }

    $user = User::findOneByColumn('api_token', $token);

    return $user instanceof User ? $user : null;
}

}
