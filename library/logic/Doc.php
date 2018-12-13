<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-12 14:25
 */

namespace library\logic;

use think\App;
use think\Container;

class Doc
{
    protected static $instance;

    protected static $config = [
        'doc_path'      => [],
        'load_path'     => [],
        'app_namespace' => '',
        'connector'     => ';'
    ];

    protected static $typeList = [
        'char', 'string', 'int', 'float', 'boolean', 'bool', 'date',
        'array', 'fixed', 'enum', 'object', 'double', 'void', 'mixed', 'file'
    ];

    private static $isConnect = false;

    public static $classMap = [];

    private static $content = '';

    /**
     * @var App
     */
    private static $app;

    /**
     * @var \think\Route
     */
    private static $route;

    public function __construct()
    {
        if (is_null(self::$app)) {
            self::$app = Container::get('app');
        }
        if (is_null(self::$route)) {
            self::$route = self::$app['route'];
        }
    }

    public static function set($config = [])
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        self::$config = array_merge(self::$config, $config);

        return self::$instance;
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public static function getClassPathList($app_path = APP_PATH, $layer = 'controller')
    {
        $app_path = rtrim($app_path, '//');

        $class_path = [];
        $dirHandle  = opendir($app_path);
        while (false !== ($fileName = readdir($dirHandle))) {
            $subFile = $app_path . DIRECTORY_SEPARATOR . $fileName;
            if (is_dir($subFile) && str_replace('.', '', $fileName) != '' && !in_array($fileName, c('deny_module_list', ['common']))) {
                $class_path[] = $subFile . DS . $layer;
            }
        }
        closedir($dirHandle);
        return $class_path;
    }

    public function doc($filter = 'public')
    {
        self::loadFiles(self::$config['load_path']);

        $doc_file_list = self::scanDir(self::$config['doc_path']);

        $class_list = [];
        foreach ($doc_file_list as $f) {
            if (isset(self::$classMap[$f])) {
                $class_list[$f] = self::$classMap[$f];
            }
        }

        $doc = [];

        foreach ($class_list as $class) {
            $class_doc = $this->makeClassDoc($class, $filter);
            array_push($doc, $class_doc);
        }

        return $doc;
    }

    private function filter($filter = null)
    {
        if (!is_null($filter)) {
            switch ($filter) {
                case 'public':
                    $filter = \ReflectionMethod::IS_PUBLIC;
                    break;
                case 'static':
                    $filter = \ReflectionMethod::IS_STATIC;
                    break;
                case 'protected':
                    $filter = \ReflectionMethod::IS_PROTECTED;
                    break;
                case 'private':
                    $filter = \ReflectionMethod::IS_PRIVATE;
                    break;
                case 'abstract':
                    $filter = \ReflectionMethod::IS_ABSTRACT;
                    break;
                case 'final':
                    $filter = \ReflectionMethod::IS_FINAL;
                    break;
            }
        }
        return $filter;
    }

    public function makeClassDoc($class = '', $filter = 'public')
    {
        $filter = $this->filter($filter);
        $doc    = [];
        if (class_exists($class)) {
            $reflectionClass   = new \ReflectionClass($class);
            $doc['name']       = $reflectionClass->name;
            $doc['file_name']  = $reflectionClass->getFileName();
            $doc['short_name'] = $reflectionClass->getShortName();
            $doc['comment']    = $this->trans($reflectionClass->getDocComment());
            $doc['property']   = \Reflection::getModifierNames($reflectionClass->getModifiers());

            $_getMethods = $reflectionClass->getMethods($filter);

            $methods = [];
            $m       = 0;
            foreach ($_getMethods as $key => $method) {
                if ($method->class == $class && strpos($method->name, '__') === false) {
                    $methods[$m] = $this->makeMethodDoc($class, $method->name);
                    $m++;
                }
            }
            $doc['methods'] = $methods;
        }
        return $doc;
    }

    public function makeMethodDoc($class, $method_name)
    {
        $reflectionClass = new \ReflectionClass($class);

        $method = $reflectionClass->getMethod($method_name);
        $temp   = str_replace(self::$config['app_namespace'], '', $class);
        $temp   = explode("\\", $temp);
        $temp   = array_values(array_filter($temp));

        $m = [];
        $m['name'] = $method->name;
        $m['path'] = strtolower($temp[0]) . "/" . strtolower($temp[2]) . "/" . $method->name;
        $route = self::$route->getName($m['path']);
        if (empty($route)) {
            $route = '';
        }
        $m['route']   = $route;
        $m['comment'] = $this->trans($method->getDocComment());

        $m['property'] = \Reflection::getModifierNames($method->getModifiers());
        return $m;
    }

    private function trans($comment)
    {
        $docComment = $comment;
        $data       = [];
        if ($docComment !== false) {
            $docCommentArr = explode("\n", $docComment);
            foreach ($docCommentArr as $key => $comment) {
                //find @ position
                $posA = strpos($comment, '@');
                if ($posA === false) {
                    if ($key == 1 && strpos($comment, '@') === false) {
                        $content       = trim(str_replace('*', ' ', $comment));
                        $data['title'] = $content;
                    }
                    continue;
                }
                $content       = trim(substr($comment, $posA));
                $needle_length = strpos($content, ' ');
                if ($needle_length === false) {
                    $needle  = str_replace('@', '', trim($content));
                    $content = '';
                } else {
                    $needle  = trim(substr($content, 1, $needle_length));
                    $content = trim(substr($content, $needle_length));
                    $content = $this->transContent($content);
                }
                if ($content === true) {
                    continue;
                }
                if (isset($data[$needle])) {
                    if (is_array($data[$needle])) {
                        array_push($data[$needle], $content);
                    } else {
                        $tmp              = $data[$needle];
                        $data[$needle]    = [];
                        $data[$needle][0] = $tmp;
                        $data[$needle][1] = $content;
                    }
                } else {
                    if (is_array($content)) {
                        $data[$needle][0] = $content;
                    } else {
                        $data[$needle] = $content;
                    }
                }
            }
        }

        return $data;
    }

    private function transContent($content)
    {
        $connector       = self::$config['connector'];
        self::$isConnect = strpos($content, $connector) === false ? false : true;
        self::$content   = self::$content . $content;
        if (self::$isConnect) {
            self::$content = str_replace($connector, '', self::$content);
            return true;
        }
        $content       = self::$content;
        self::$content = '';
        if (strpos($content, ' ') !== false) {
            $content      = preg_replace("/[\s]+/is", " ", $content);
            $contentArray = explode(' ', $content);
            if (isset($contentArray[0]) && !$this->isType($contentArray[0])) {
                return $content;
            }
            $data = [
                'type' => isset($contentArray[0]) ? $contentArray[0] : '',
                'name' => isset($contentArray[1]) ? $contentArray[1] : ''
            ];
            $desc = '';
            foreach ($contentArray as $k => $c) {
                if ($k < 2) {
                    continue;
                }
                if (!empty($c)) {
                    $desc = $desc . trim($c) . ' ';
                }
            }

            $data['desc'] = trim($desc);
            $content      = $data;
        }
        return $content;
    }

    private function isType($type = '')
    {
        if (strpos($type, '|')) {
            $array = explode('|', $type);
            foreach ($array as $a) {
                if (in_array(strtolower($a), self::$typeList)) {
                    return true;
                }
            }
        } else {
            if (in_array(strtolower($type), self::$typeList)) {
                return true;
            }
        }
        return false;
    }

    private static function scanDir($dir)
    {
        $file_list = [];
        if (is_string($dir)) {
            self::deepScanDir($dir, $file_list);
        } else if (is_array($dir)) {
            $file_list = [];
            foreach ($dir as $d) {
                if (is_string($d)) {
                    self::deepScanDir($d, $list);
                    foreach ($list as $l) {
                        array_push($file_list, $l);
                    }
                }
            }
        }
        return $file_list;
    }

    private static function loadFiles($dir)
    {
        $files = self::scanDir($dir);
        foreach ($files as $k => $f) {
            if (strpos($f, '.php') !== false) {
                require_once $f;
                $content            = file_get_contents($f);
                $namespace_begin    = strpos($content, 'namespace') + 10;
                $namespace_end      = strpos($content, ';');
                $class              = substr($content, $namespace_begin, $namespace_end - $namespace_begin) . '\\' . basename($f, '.php');
                self::$classMap[$f] = $class;
            }
        }
    }

    private static function deepScanDir($dir, &$fileArr = [])
    {
        if (is_null($fileArr)) {
            $fileArr = [];
        }
        $dir = rtrim($dir, '//');

        if (is_dir($dir)) {
            $dirHandle = opendir($dir);
            while (false !== ($fileName = readdir($dirHandle))) {
                $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
                if (is_file($subFile)) {
                    array_push($fileArr, $subFile);
                } elseif (is_dir($subFile) && str_replace('.', '', $fileName) != '') {
                    self::deepScanDir($subFile, $fileArr);
                }
            }
            closedir($dirHandle);
        }
    }
}