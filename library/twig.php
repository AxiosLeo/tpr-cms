<?php

declare(strict_types=1);

return [
    'selected' => function ($menuModule, $currModule) {
        return $menuModule === $currModule;
    },
    'dump' => function (...$data) {
        call_user_func_array('dump', $data);
    },
    'url' => function ($module, $controller, $action) {
        return url($module, $controller, $action);
    },
];
