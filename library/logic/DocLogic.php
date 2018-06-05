<?php
/**
 * @author: axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/9/18 上午9:24
 */

namespace library\logic;

use library\exception\NamespaceException;
use library\exception\PathNotException;
use tpr\framework\App;
use tpr\framework\Cache;
use tpr\framework\Doc;

/**
 * @package library\logic
 */
class DocLogic
{
    protected static $APP_PATH = null;

    protected static $is_cache = false;

    public static $appMap = [];

    /**
     * check the path exist
     * @param string $path
     * @param string $type
     */
    protected static function checkPath($path, $type = 'path')
    {
        if (!is_dir($path)) {
            throw new PathNotException("The " . $type . ": \"" . $path . "\" is not exist");
        }
    }

    /**
     * @param $app_path
     * @return mixed
     */
    protected static function checkNamespace($app_path)
    {
        if (empty(self::$appMap)) {
            $app_path = self::setAppPath($app_path);
            self::appList();
        }
        if (!isset(self::$appMap[$app_path])) {
            throw new NamespaceException("namespace is not exist. app path is " . $app_path);
        }
        return self::$appMap[$app_path];
    }

    /**
     * @param string $app_path
     * @return string
     */
    public static function setAppPath($app_path)
    {
        if (is_dir($app_path)) {
            self::$APP_PATH = $app_path;
        }

        self::checkPath(self::$APP_PATH, 'app path');

        return self::$APP_PATH;
    }

    /**
     * @param string $app_path
     * @return array|mixed
     */
    public static function doc($app_path = null)
    {
        $app_path = self::setAppPath($app_path);

        $cache = Cache::get('api_doc_' . $app_path);
        if (!App::$debug && !empty($cache)) {
            $doc = $cache;
            self::$is_cache = true;
        } else {
            self::checkNamespace($app_path);
            $app_namespace = data(self::$appMap, $app_path, null);

            $doc_path = Doc::getClassPathList($app_path);

            $config = [
                'doc_path' => $doc_path,
                'load_path' => [
                    ROOT_PATH . 'library/',
                    $app_path
                ],
                'app_namespace' => $app_namespace,
            ];

            $doc = Doc::set($config)->doc();

            Cache::set('api_doc_' . $app_path, $doc, 86400);
            self::$is_cache = false;
        }
        return $doc;
    }

    /**
     * @param string $class
     * @param string $module
     * @param string $app_path
     * @return array
     */
    public static function apiList($class = null, $module = null, $app_path = null)
    {
        $filter = !empty($module);

        $app_path = self::setAppPath($app_path);

        $class_list = self::doc($app_path);

        $all = empty($class);

        $api_list = [];

        $app_namespace = self::checkNamespace($app_path);

        foreach ($class_list as $d) {
            if ($filter && strpos($d['name'], $module) === false) {
                continue;
            }
            $methods = $all || $d['name'] == $class ? $d['methods'] : [];

            foreach ($methods as $m) {
                $comment = $m['comment'];
                $api = [
                    'title'      => data($comment,'title'),
                    'name'       => $m['name'],
                    'path'       => $m['path'],
                    'route'      => $m['route'],
                    'file_name'  => $d['file_name'],
                    'class_name' => $d['name'],
                    'app_namespace'   => $app_namespace
                ];
                array_push($api_list, $api);
            }
        }

        return $api_list;
    }

    /**
     * @param string $module
     * @param string $app_path
     * @return array
     */
    public static function classList($module = null, $app_path = null)
    {
        $filter = !empty($module);

        $doc = self::doc($app_path);

        $class_list = [];
        foreach ($doc as $d) {
            if ($filter && strpos($d['name'], $module) === false) {
                continue;
            }

            $comment = $d['comment'];

            $class = [
                'title' => data($comment, 'title', $d['name']),
                'name' => $d['name'],
                'file_name' => $d['file_name']
            ];

            array_push($class_list, $class);
        }

        return $class_list;
    }

    /**
     * @param string $app_path
     * @return array
     */
    public static function moduleList($app_path)
    {
        $app_path = self::setAppPath($app_path);

        $dir = rtrim($app_path, '//');
        $app_name = basename($app_path);

        $module_list = [];

        if (is_dir($dir)) {
            $dirHandle = opendir($dir);
            while (false !== ($fileName = readdir($dirHandle))) {
                $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
                if (is_dir($subFile) && str_replace('.', '', $fileName) != '') {
                    $data = [
                        'path' => $subFile,
                        'name' => $fileName,
                        'namespace' => BASE_NAMESPACE . "\\" . $app_name . "\\" . $fileName
                    ];
                    array_push($module_list, $data);
                }
            }
            closedir($dirHandle);
        }

        return $module_list;
    }

    /**
     * @param string $dir
     * @param array $exception
     * @return array
     */
    public static function appList($dir = ROOT_PATH . 'application/', $exception = [])
    {
        $dir = rtrim($dir, '//');

        $app_list = [];

        if (is_dir($dir)) {
            $dirHandle = opendir($dir);
            while (false !== ($fileName = readdir($dirHandle))) {
                $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
                if (is_dir($subFile) && str_replace('.', '', $fileName) != '' && !in_array($fileName, $exception)) {
                    $data = [
                        'path' => $subFile,
                        'name' => $fileName,
                        'namespace' => BASE_NAMESPACE . "\\" . $fileName
                    ];
                    array_push($app_list, $data);
                }
            }
            closedir($dirHandle);
        }

        foreach ($app_list as $app) {
            self::$appMap[$app['path']] = $app['namespace'];
        }

        return $app_list;
    }
}