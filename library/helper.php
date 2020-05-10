<?php

declare(strict_types=1);

namespace cms;

use tpr\Container;

function data($array, $index, $default = '')
{
    return isset($array[$index]) ? $array[$index] : $default;
}

function halt(...$data)
{
    \call_user_func_array('dump', $data);
    die();
}

function createUrl($module, $controller, $action)
{
    // @var \tpr\core\request\DefaultRequest $request
    $request = Container::get('request');

    return $request->indexFile() . '/' . $module . '/' . $controller . '/' . $action;
}
