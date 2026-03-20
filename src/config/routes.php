<?php

return [
    '~^articles$~' => [\Src\Controllers\ArticlesController::class,'index'],
    '~^article/(\d+)$~' => [\Src\Controllers\ArticlesController::class,'view'],
    '~^hello/(.*)$~' => [\Src\Controllers\MainController::class,'sayHello'],
    '~test/(.*)$~' => [\Src\Controllers\testController::class,'view'],
    '~^$~' => [\Src\Controllers\MainController::class,'main'],
];