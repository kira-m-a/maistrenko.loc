<?php

return[
  '~^articles$~' => [\src\controllers\ArticlesController::class,'index'], 
  '~^articles/add$~' => [\src\controllers\ArticlesController::class,'add'],
  '~^article/(\d+)$~' => [\src\controllers\ArticlesController::class,'view'],
  '~^article/(\d+)/edit$~' => [\src\controllers\ArticlesController::class,'edit'],
  '~^article/(\d+)/delete$~' => [\src\controllers\ArticlesController::class,'delete'],
  '~^article/search$~' => [\src\controllers\ArticlesController::class,'search'],
  '~^users/signUp$~' => [\src\controllers\UsersController::class,'signUp'],
  '~^users/login$~' => [\src\controllers\UsersController::class,'login'],
  '~^users$~' => [\src\controllers\UsersController::class,'index'],
  '~^users/logout$~' => [\src\controllers\UsersController::class,'logout'],
 '~^$~' => [\src\controllers\MainController::class,'main'], 

]; 