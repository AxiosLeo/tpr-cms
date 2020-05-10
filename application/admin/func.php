<?php

declare(strict_types=1);

use tpr\Container;

return [
    'selected' => function ($menuModule, $currModule) {
        return $menuModule === $currModule;
    },
    'dump'     => function (...$data) {
        call_user_func_array('dump', $data);
    },
    'url'      => function ($module, $controller, $action) {
        // @var \tpr\core\request\DefaultRequest $request
        $request = Container::get('request');

        return $request->indexFile() . '/' . $module . '/' . $controller . '/' . $action;
    },
];
