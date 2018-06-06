<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/8/28 下午1:36
 */

if(!function_exists('make_password')){
    /**
     * @param $password
     * @param string $auth
     * @return string
     */
    function make_password($password, $auth = '')
    {
        return md5($auth . $password);
    }
}

if (!function_exists('is_user_login')) {
    function is_user_login($prefix = PROJECT_NAME)
    {
        $user = \tpr\framework\Session::has($prefix . '_user');
        return empty($user) ? false : true;
    }
}

if(!function_exists('clear_user_login')){
    function clear_user_login($prefix = PROJECT_NAME){
        \tpr\framework\Session::delete($prefix . '_user');
        return true;
    }
}

if (!function_exists('user_info')) {
    function user_info($field = '',$prefix = PROJECT_NAME)
    {
        $user = \tpr\framework\Session::get($prefix . '_user');
        if (empty($field)) {
            return $user;
        }
        $data = [];
        if (is_string($field)) {
            if (strpos($field, ',')) {
                $keys = explode(',', $field);
                foreach ($keys as $k) {
                    $data[$k] = data($user, $k);
                }
            } else {
                return data($user, $field);
            }
        } elseif (is_array($field)) {
            foreach ($field as $k) {
                $data[$k] = data($user, $k);
            }
        }
        $user = $data;
        return $user;
    }
}

if (!function_exists('user_save')) {
    function user_save($user,$prefix = PROJECT_NAME)
    {
        \tpr\framework\Session::set($prefix . '_user', $user);
    }
}

if (!function_exists('user_current_id')) {
    function user_current_id($id_index = 'id',$prefix = PROJECT_NAME)
    {
        return user_info($id_index, $prefix);
    }
}

if (!function_exists('getLastUrl')) {
    function getLastUrl()
    {
        return \tpr\framework\Session::get('last_url');
    }
}

if(!function_exists('get_avatar')){
    function get_user_avatar($avatar = null){
        if(empty($avatar)){
            $avatar = user_info('avatar');
        }
        return !empty($avatar) && file_exists(ROOT_PATH . 'public/' . $avatar) ? $avatar : '/src/images/avatar.png';
    }
}

if(!function_exists('rand_upper')){
    function rand_upper($str){
        $len = strlen($str);
        for ($i=0 ; $i<$len; $i++){
            $str[$i] = mt_rand(0,1) ? strtoupper($str[$i]) : strtolower($str[$i]);
        }
        return $str;
    }
}

\tpr\framework\Route::get('captcha/[:id]', "\\tpr\\controller\\CaptchaController@index");
\tpr\framework\Validate::extend('captcha', function ($value, $id = '') {
    return captcha_check($value, $id);
});
\tpr\framework\Validate::setTypeMsg('captcha', ':attribute错误!');
/**
 * @param string $id
 * @param array  $config
 * @return \tpr\framework\Response
 */
function captcha($id = '', $config = [])
{
    $captcha = new \tpr\framework\Captcha($config);
    return $captcha->entry($id);
}
/**
 * @param $id
 * @return string
 */
function captcha_src($id = '')
{
    return \tpr\framework\Url::build('/captcha' . ($id ? "/{$id}" : ''));
}
/**
 * @param $id
 * @return mixed
 */
function captcha_img($id = '')
{
    return '<img src="' . captcha_src($id) . '" alt="captcha" />';
}
/**
 * @param        $value
 * @param string $id
 * @return bool
 */
function captcha_check($value, $id = '')
{
    $captcha = new \tpr\framework\Captcha((array)\tpr\framework\Config::get('captcha'));
    return $captcha->check($value, $id);
}