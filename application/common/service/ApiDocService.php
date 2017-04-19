<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/19 11:41
 */
namespace app\common\service;

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
            $doc['file_name'] = $reflectionClass->getFileName();
            $doc['short_name'] = $reflectionClass->getShortName();
            $doc['class_comment'] = self::trans($reflectionClass->getDocComment());
            $_getMethods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
            $methods = [];$m=0;
            foreach ($_getMethods as $key=>$method){
                if($method->class==$class){
                    $methods[$m]['name']=$method->name;
                    $methods[$m]['method_comment']=self::trans($method->getDocComment());
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
        $param_count  = 0;
        $return = '@return';
        $return_count = 0;

        $typeMaps = array(
            'string'  => '字符串',
            'int'     => '整型',
            'float'   => '浮点型',
            'boolean' => '布尔型',
            'date'    => '日期',
            'array'   => '数组',
            'fixed'   => '固定值',
            'enum'    => '枚举类型',
            'object'  => '对象',
        );

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
                    $return[$return_count]['type'] = isset($temp[0]) && isset($typeMaps[$temp[0]]) ?$typeMaps[$temp[0]]:"";
                    $return[$return_count]['name'] = isset($temp[1]) ?$temp[1]:"";
                    $return[$return_count]['info'] = isset($temp[2]) ?$temp[2]:"";
                    $return_count++;
                }
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
                    $param[$param_count]['type'] = isset($temp[0]) && isset($typeMaps[$temp[0]]) ?$typeMaps[$temp[0]]:"";
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
            'param' => $param,
            'return'=> $return,
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