<?php

declare(strict_types=1);

use tpr\Container;

if (!function_exists('getDayBeginEndTime')) {
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
}

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
