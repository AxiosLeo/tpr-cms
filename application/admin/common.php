<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

if (!function_exists('make_password')) {
    /**
     * @param        $password
     * @param string $auth
     *
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
        $user = \think\facade\Session::has($prefix . '_user');
        return empty($user) ? false : true;
    }
}

if (!function_exists('clear_user_login')) {
    function clear_user_login($prefix = PROJECT_NAME)
    {
        \think\facade\Session::delete($prefix . '_user');
        return true;
    }
}

if (!function_exists('user_info')) {
    function user_info($field = '', $prefix = PROJECT_NAME)
    {
        $user = \think\facade\Session::get($prefix . '_user');
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
    function user_save($user, $prefix = PROJECT_NAME)
    {
        \think\facade\Session::set($prefix . '_user', $user);
    }
}

if (!function_exists('user_current_id')) {
    function user_current_id($id_index = 'id', $prefix = PROJECT_NAME)
    {
        return user_info($id_index, $prefix);
    }
}

if (!function_exists('getLastUrl')) {
    function getLastUrl()
    {
        return \think\facade\Session::get('last_url');
    }
}

if (!function_exists('get_avatar')) {
    function get_user_avatar($avatar = null)
    {
        if (empty($avatar)) {
            $avatar = user_info('avatar');
        }
        return !empty($avatar) && file_exists(ROOT_PATH . 'public/' . $avatar) ? $avatar : '/src/images/avatar.png';
    }
}

if (!function_exists('rand_upper')) {
    function rand_upper($str)
    {
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $str[$i] = mt_rand(0, 1) ? strtoupper($str[$i]) : strtolower($str[$i]);
        }
        return $str;
    }
}

if (!function_exists('captcha_src')) {
    function captcha_src()
    {
        return url('index/message/captcha', ['salt' => \library\logic\Tool::uuid()]);
    }
}

if (!function_exists('captcha_check')) {
    function captcha_check($a)
    {
        $captcha = \think\facade\Session::get('captcha');
        if (empty($a)) {
            return false;
        } else if (empty($captcha)) {
            return false;
        } else if ($captcha != $a) {
            return false;
        } else {
            return true;
        }
    }
}


if (!function_exists('captcha_create')) {
    function captcha_create()
    {
        $captcha = new \Minho\Captcha\CaptchaBuilder();

        $captcha->initialize([
            'width'  => 150,      // 宽度
            'height' => 50,       // 高度
            'line'   => false,    // 直线
            'curve'  => false,     // 曲线
            'noise'  => 1,        // 噪点背景
            'fonts'  => [],       // 字体
            'number' => 5
        ]);
        $captcha->create();
        \think\facade\Session::set('captcha', $captcha->getText());
        ob_start();
        $captcha->output(1);
        $output = ob_get_clean();
        return $output;
    }
}
