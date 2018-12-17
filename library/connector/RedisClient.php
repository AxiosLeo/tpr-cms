<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-17 11:21
 */

namespace library\connector;

use tpr\db\DbRedis;

class RedisClient
{
    public static function init($redis_config_index = '')
    {
        $redis_config = c($redis_config_index, []);
        return DbRedis::init($redis_config_index, $redis_config);
    }
}