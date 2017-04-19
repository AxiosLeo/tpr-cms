<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/19 11:41
 */
namespace app\common\service;

use think\Route;

class ApiDocService{
    public static function api($class=''){
        $ApiClass = self::scanApiClass();
        $list = [];$n=0;
        if(!empty($class)){
            $list = self::makeDoc($class);
        }else{
            foreach ($ApiClass as $k=>$api){
                $doc =  self::makeDoc($api);
                if(!empty($doc)){
                    $list[$n++] = $doc;
                }
            }
        }

        return $list;
    }

    public static function makeDoc($class=''){
        $doc = [];
        if(class_exists($class)){
            $reflectionClass = new \ReflectionClass($class);
            $doc['name'] = $reflectionClass->name;
            $temp = explode("\\",$doc['name']);
            $doc['file_name'] = $reflectionClass->getFileName();
            $doc['short_name'] = $reflectionClass->getShortName();
            $comment = self::trans($reflectionClass->getDocComment());
            $doc['title'] = $comment['title'];
            $doc['desc'] = $comment['desc'];
            $doc['package']=$comment['package'];
            $_getMethods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
            $methods = [];$m=0;
            foreach ($_getMethods as $key=>$method){
                if($method->class==$class){
                    $methods[$m]['name']=$method->name;
                    $methods[$m]['path'] = strtolower($temp[1])."/".strtolower($temp[3])."/".$method->name;
                    $rule =  Route::name($methods[$m]['path']);
                    $route = '';
                    if(!empty($rule)){
                        $route = $rule[0][0];
                    }
                    $methods[$m]['route'] = $route;
                    $method_comment = self::trans($method->getDocComment());
                    $methods[$m]['title'] = $method_comment['title']=="@title"?$method->name:$method_comment['title'];
                    $methods[$m]['desc'] = $method_comment['desc']=="@desc"?"":$method_comment['desc'];
                    $methods[$m]['method'] = $method_comment['method']=="@method"?"":strtoupper($method_comment['method']);
                    $methods[$m]['parameter'] = $method_comment['parameter']=="@parameter"?"":$method_comment['parameter'];
                    $methods[$m]['return'] = $method_comment['return']=="@return"?"":$method_comment['return'];
                    $m++;
                }
            }
            $doc['methods'] = $methods;
        }
        return $doc;
    }

    public static function trans($comment){
        $title  = '@title';
        $desc   = '@desc';
        $package= '@package';
        $param  = '@parameter';
        $method = '';
        $param_count  = 0;
        $return = '@return';
        $return_count = 0;

        $docComment = $comment;
        if ($docComment !== false) {
            $docCommentArr = explode("\n", $docComment);
            $comment = trim($docCommentArr[1]);
            $title = trim(substr($comment, strpos($comment, '*') + 1));

            foreach ($docCommentArr as $comment) {
                //@desc
                $pos = stripos($comment, '@desc');
                if ($pos !== false) {
                    $desc = trim(substr($comment, $pos + 5));
                }

                //@package
                $pos = stripos($comment, '@package');
                if ($pos !== false) {
                    $package = trim(substr($comment, $pos + 8));
                }

                //@method
                $pos = stripos($comment, '@method');
                if ($pos !== false) {
                    $method = trim(substr($comment, $pos + 8));
                }

                //@return
                $pos = stripos($comment, '@return');
                if($pos !== false){
                    $temp = explode(" ",trim(substr($comment,$pos + 7)));
                    $tn = 0;$tt=[];
                    foreach ($temp as $k=>$t){
                        if(empty($t)){
                            unset($temp[$k]);
                        }else{
                            $tt[$tn++]=$t;
                        }
                    }
                    $temp = $tt;
                    $return = [];
                    $return[$return_count]['type'] = isset($temp[0]) ?LangService::trans($temp[0]):"";
                    $return[$return_count]['name'] = isset($temp[1]) ?$temp[1]:"";
                    $return[$return_count]['info'] = isset($temp[2]) ?$temp[2]:"";
                    $return_count++;
                }

                //@parameter
                $pos = stripos($comment, '@parameter');
                if($pos !== false){
                    $temp = explode(" ",trim(substr($comment,$pos + 10)));
                    $tn = 0;$tt=[];
                    foreach ($temp as $k=>$t){
                        if(empty($t)){
                            unset($temp[$k]);
                        }else{
                            $tt[$tn++]=$t;
                        }
                    }
                    $temp = $tt;
                    $param = [];
                    $param[$param_count]['type'] = isset($temp[0]) ?LangService::trans($temp[0]):"";
                    $param[$param_count]['name'] = isset($temp[1]) ?$temp[1]:"";
                    $param[$param_count]['info'] = isset($temp[2]) ?$temp[2]:"";
                    $param_count++;
                }
            }
        }

        $comment = [
            'title' => $title,
            'desc'  => $desc,
            'package'=>$package,
            'parameter' => $param,
            'return'=> $return,
            'method'=>$method,
        ];

        return $comment;
    }

    public static function deepScanDir($dir) {
        $fileArr = array ();
        $dirArr = array ();
        $dir = rtrim($dir, '//');
        if (is_dir($dir)) {
            $dirHandle = opendir($dir);
            while (false !== ($fileName = readdir($dirHandle))) {
                $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
                if (is_file($subFile)) {
                    $fileArr[] = $subFile;
                }
                elseif (is_dir($subFile) && str_replace('.', '', $fileName) != '') {
                    $dirArr[] = $subFile;
                    $arr = self::deepScanDir($subFile);
                    $dirArr = array_merge($dirArr, $arr['dir']);
                    $fileArr = array_merge($fileArr, $arr['file']);
                }
            }
            closedir($dirHandle);
        }
        return array (
            'dir' => $dirArr,
            'file' => $fileArr
        );
    }

    public static function scanApiClass(){
        $scan = self::deepScanDir(APP_PATH);
        $files = $scan['file'];
        foreach ($files as $k=>$f){
            if(strpos($f,"controller") && !strpos($f,"common")){
                require_once $f;
            }
        }
        $class = get_declared_classes();
        $n=0;$ApiList = [];
        foreach ($class as $k=>$c){
            if(strpos($c,"controller") && !strpos($c,"common") && !strpos($c,'admin')){
                $ApiList[$n++]=$c;
            }
        }
        return $ApiList;
    }
}