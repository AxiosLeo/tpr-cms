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

function getDayBeginEndTime($date, $format='timestamp')
{
    $begin = strtotime($date . ' 00:00:00');
    $end   = strtotime("{$date} +1 day -1 seconds");
    if ('timestamp' == $format) {
        return [
            'begin'=> $begin,
            'end'  => $end,
        ];
    }

    return [
        'begin'=> date($format, $begin),
        'end'  => date($format, $end),
    ];
}
