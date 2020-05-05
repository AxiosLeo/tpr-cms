<?php

declare(strict_types = 1);

use tpr\Container;

return [
    'testFunc' => function ($a) {
        return $a . '-test';
    },
    'selected' => function ($menuModule, $currModule) {
        return $menuModule === $currModule;
    },
    'dump'     => function (...$data) {
        call_user_func_array('dump', $data);
    },
    'url'      => function ($module, $controller, $action) {
        /* @var \tpr\core\request\RequestAbstract $request */
        $request = Container::get('request');
        return $request->url() . '/' . $module . '/' . $controller . '/' . $action;
    }
];
