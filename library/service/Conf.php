<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-30 23:40
 */

namespace library\service;

use api\tool\lib\ArrayTool;
use tpr\framework\Config;

class Conf
{
    /**
     * @var ArrayTool
     */
    private static $config;

    public static function get($key = null, $default = null)
    {
        if (is_null(self::$config)) {
            self::$config = ArrayTool::instance(Config::get());
        }
        return self::$config->get($key, $default);
    }
}