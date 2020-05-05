<?php

declare(strict_types=1);

function data($array, $index, $default = '')
{
    return isset($array[$index]) ? $array[$index] : $default;
}

function halt(...$data)
{
    call_user_func_array('dump', $data);
    die();
}
