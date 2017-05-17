<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/5/17 11:03
 */

/**
 * @param $password
 * @param $auth
 * @return string
 */
function make_password($password,$auth=''){
    return md5($auth.$password);
}