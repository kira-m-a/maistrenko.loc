<?php

return [
    '~^articles$~'       => [\src\controllers\api\ArticlesApiController::class, 'GET' => 'all', 'POST' => 'add'],
    '~^articles/(\d+)$~' => [\src\controllers\api\ArticlesApiController::class, 'GET' => 'view', 'DELETE' => 'delete', 'PUT' => 'edit', 'PATCH' => 'edit'],
    '~^user$~'           => [\src\controllers\api\UsersApiController::class, 'GET' => 'user'],
    '~^user/login$~'     => [\src\controllers\api\UsersApiController::class, 'POST' => 'login'],
    '~^user/auth$~' => [\src\controllers\api\UsersApiController::class, 'GET' => 'auth'],

];
