<?php

namespace src\controllers\api;

use src\controllers\Controller;
use src\models\User;
use src\models\UsersAuthService;

abstract class ApiController extends Controller
{
    /** @var User|null */
    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = UsersAuthService::getUserByAuthBasic();
    }
}
