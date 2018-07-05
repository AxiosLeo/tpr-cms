<?php
/**
 * @author: axios
 *
 * @email: axiosleo@foxmail.com
 * @blog:  http://hanxv.cn
 * @datetime: 2018/2/2 15:33
 */

namespace library\extend\workman\lib;

use tpr\framework\App;
use tpr\framework\exception\RouteNotFoundException;
use tpr\framework\Lang;
use tpr\framework\Route;

class Run extends App
{
    public static function request($path,\tpr\framework\Request $request , $config){
        if (defined('BIND_MODULE')) {
            // 模块/控制器绑定
            BIND_MODULE && Route::bind(BIND_MODULE);
        } elseif ($config['auto_bind_module']) {
            // 入口自动绑定
            $name = pathinfo($request->baseFile(), PATHINFO_FILENAME);
            if ($name && 'index' != $name && is_dir(APP_PATH . $name)) {
                Route::bind($name);
            }
        }

        $request->filter($config['default_filter']);

        // 默认语言
        Lang::range($config['default_lang']);
        if ($config['lang_switch_on']) {
            // 开启多语言机制 检测当前语言
            Lang::detect();
        }
        $request->langset(Lang::range());

        // 加载系统语言包
        Lang::load([
            TPR_PATH . 'lang' . DS . $request->langset() . EXT,
            APP_PATH . 'lang' . DS . $request->langset() . EXT,
            CONF_PATH . 'lang' . DS . $request->langset() . EXT
        ]);

        // 获取应用调度信息
        $dispatch = self::$dispatch;
        if (empty($dispatch)) {
            // 进行URL路由检测
            $dispatch = self::checkRoute($path, $request, $config);
        }
        // 记录当前调度信息
        $request->dispatch($dispatch);
        return $dispatch;
    }
    public static function exec($dispatch, $config)
    {
        return parent::exec($dispatch, $config);
    }

    public static function checkRoute($path , \tpr\framework\Request $request, array $config)
    {
        $depr = $config['pathinfo_depr'];
        $result = false;
        // 路由检测
        $check = !is_null(self::$routeCheck) ? self::$routeCheck : $config['url_route_on'];
        if ($check) {
            // 路由检测（根据路由定义返回不同的URL调度）
            $result = Route::check($request, $path, $depr, $config['url_domain_deploy']);
            $must = !is_null(self::$routeMust) ? self::$routeMust : $config['url_route_must'];
            if ($must && false === $result) {
                // 路由无效
                throw new RouteNotFoundException();
            }
        }
        if (false === $result) {
            // 路由无效 解析模块/控制器/操作/参数... 支持控制器自动搜索
            $result = Route::parseUrl($path, $depr, $config['controller_auto_search']);
        }
        return $result;
    }
}