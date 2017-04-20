<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/20 13:55
 */
namespace app\common\service;
/**
 * Class CryptService
 * @package app\common\service
 */
class CryptService {
    private static $key_path;
    private static $pri_key;
    private static $pub_key;

    public static function path($select=''){
        if(!empty($select)){
            self::$key_path = CONF_PATH."key/".$select."/";
        }else{
            self::$key_path = CONF_PATH."key/";
        }
        if (!file_exists(self::$key_path)){
            if (!mkdir(self::$key_path, 0700, true)) {
                return strval(file_exists(self::$key_path)).'Failed to create folders:'.self::$key_path;
            }
        }
        return self::$key_path;
    }

    public static function rsa($select=''){
        self::path($select);
        self::$pri_key = file_get_contents(self::$key_path."pri.pem");
        self::$pub_key = file_get_contents(self::$key_path."pub.pem");
        return new self();
    }

    public static function makeKey($select=''){
        $res = openssl_pkey_new();
        openssl_pkey_export($res, $pri_key);

        self::path($select);
        file_put_contents(self::$key_path.'pri.pem',$pri_key);
        self::$pri_key = $pri_key;

        $res = openssl_pkey_get_details($res);
        self::$pub_key = $res['key'];
        file_put_contents(self::$key_path."pub.pem",self::$pub_key);
    }

    public function encrypt($data,$encrypt='pri'){
        $str = '';$count=0;
        for($i=0; $i<strlen($data); $i+=128){
            $src = substr($data, $i, 128);
            $out = $encrypt=='pri'?self::doEncrypt($src,1):self::doEncrypt($src,0);
            if($out===NULL){
                return NULL;
            }
            $str .= $count==0 ? base64_encode($out):",".base64_encode($out);
            $count++;
        }
        return $str;
    }

    public function decrypt($data,$decrypt='pri'){
        $str = '';
        if(strpos($data,",")){
            $dataArray = explode(",",$data);
            foreach ($dataArray as $src){
                $out= $decrypt=='pri'?self::doDecrypt(base64_decode($src),1):self::doDecrypt(base64_decode($src),0);
                if($out===NULL){
                    return NULL;
                }
                $str .= $out;
            }
        }else{
            $src=base64_decode($data);
            $out= $decrypt=='pri'?self::doDecrypt($src,1):self::doDecrypt($src,0);
            if($out===NULL){
                return NULL;
            }
            $str .= $out;
        }

        return $str;
    }

    private static function doEncrypt($src,$type=1){
        $rs = '';
        $result = $type?@openssl_private_encrypt($src, $rs, self::$pri_key) : @openssl_public_encrypt($src, $rs, self::$pub_key);
        if ($result===FALSE) {
            return NULL;
        }
        return $rs;
    }

    private static function doDecrypt($src,$type=1){
        $rs = '';
        $result = $type?@openssl_private_decrypt($src, $rs, self::$pri_key) : @openssl_public_decrypt($src, $rs, self::$pub_key);
        if ($result===FALSE) {
            return NULL;
        }
        return $rs;
    }

}