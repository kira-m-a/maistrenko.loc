<?php

return [
    '~^hello/(.*)$~' => [\Src\Controllers\MainController::class,'sayHello'],
    '~test/(.*)$~' => [\Src\Controllers\testController::class,'view'],
    '~^$~' => [\Src\Controllers\MainController::class,'main'],
];