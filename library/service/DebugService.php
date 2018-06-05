<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/7/26 13:09
 */

namespace library\service;


use tpr\framework\Tool;

class DebugService
{
    public static function save($filename = null, $content = 'default', $append = true)
    {
        if(empty($filename)){
            $filename = ROOT_PATH . 'test.log';
        }
        $type = $append ? 'a+' : 'w+';
        $fp = fopen($filename, $type);
        if (flock($fp, LOCK_EX)) {
            if(is_array($content) || is_object($content)){
                $content = dump($content, false);
            }

            fwrite($fp, $content . "\r\n-------------\r\n");
            flock($fp, LOCK_UN);
        }
        fclose($fp);
        if(get_current_user() == 'root'){
            chmod($filename,0777);
        }
    }

    public static function log($content = 'default', $label = null , $append = true){
        $runtime_path = RUNTIME_PATH . '../debug/'.date("Ym").'/';
        if (!file_exists($runtime_path)) {
            if (!mkdir($runtime_path, 0700, true)) {
                return strval(file_exists($runtime_path)) . 'Failed to create folders:' . $runtime_path;
            }
        }

        if(is_array($content)){
            $content = dump($content , false , $label);
        }

        $log_path = $runtime_path . date("d") . "_debug.log";

        self::save($log_path,$content,$append);

        if(get_current_user() == 'root'){
            chmod($log_path,0777);
        }

        return $log_path;
    }

    /**
     * push beer
     * @param array $data
     * @param string $label
     * @param string $sendKey
     */
    public static function wechatPush($data = [], $label = "debug" , $sendKey = ""){
        $info = dump($data,false);
        if(is_array($sendKey)){
            foreach ($sendKey as $sk){
                Tool::curl('https://pushbear.ftqq.com/sub?sendkey='.$sk.'&text='.$label,['desp'=>$info]);
            }
        }else if(is_string($sendKey)){
            Tool::curl('https://pushbear.ftqq.com/sub?sendkey='.$sendKey.'&text='.$label,['desp'=>$info]);
        }
    }
}