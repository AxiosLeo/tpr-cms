<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/18 下午2:03
 */

namespace library\exception;


class NamespaceException extends \RuntimeException
{

    public function __construct($message)
    {
        $this->message = $message;
    }
}