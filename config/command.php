<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    :  http://hanxv.cn
 * @datetime: 2018/5/15 20:09
 */

$dir  = APP_PATH;
$list = [];
if (is_dir($dir)) {
    $dir = substr($dir, -1) != DIRECTORY_SEPARATOR ? $dir . DIRECTORY_SEPARATOR : $dir;
    if (!file_exists($dir)) {
        if (!mkdir($dir, 0700, true)) {
            return null;
        }
    }

    $dirHandle = opendir($dir);
    while (false !== ($fileName = readdir($dirHandle))) {
        $subFile = $dir . $fileName;
        $tmp     = str_replace('.', '', $fileName);
        if (!is_dir($subFile) && $tmp != '' && !in_array($fileName, ["Base.php"])) {
            array_push($list, APP_NAMESPACE . "\\" . basename($subFile, ".php"));
        }
    }
    closedir($dirHandle);
}

return $list;