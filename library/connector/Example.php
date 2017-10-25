<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/10/23 10:59
 */

namespace library\connector;

/**
 * Class Example
 * @package library\connector
 * @example Example::name($name) ; Example::name($name)
 */
class Example
{
    protected static $connect = "mysql.example";  // config in "CONF_PATH/extra/mysql.php"  and config name is "example"

    use Base;
}