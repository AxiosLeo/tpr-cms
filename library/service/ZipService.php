<?php
/**
 * @author  : axios
 * @email   : axiosleo@foxmail.com
 * @blog    : http://hanxv.cn
 * @datetime: 2018-12-30 23:33
 */

namespace library\service;

use tpr\framework\Tool;
use \ZipArchive;

class ZipService
{
    private static $instance;

    private static $zip_path;

    private static $err_info = "";

    public static function instance($zip_path = null)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        if (!is_null($zip_path) && $zip_path !== self::$zip_path) {
            self::$zip_path = $zip_path;
        }
        return self::$instance;
    }

    public static function clear()
    {
        self::$instance = null;
    }

    private $uniq;

    private $zipArchive;

    private $file_list = [];

    public function __construct()
    {
        $this->uniq       = Tool::uuid();
        $this->zipArchive = new ZipArchive();
    }

    public function setZipPath($zip_path)
    {
        self::$zip_path = $zip_path;
        return $this;
    }

    public function zip($save_path)
    {
        if (is_dir($save_path)) {
            self::$err_info = 'save_path must be zip file : ' . $save_path;
            return false;
        }
        $this->zipArchive = new ZipArchive();
        if ($this->zipArchive->open($save_path, ZipArchive::CREATE) !== true) {
            self::$err_info = 'can not open ' . $save_path;
            return false;
        }

        $this->addFileList(self::$zip_path, [".DS_Store"]);
        foreach ($this->file_list as $filename) {
            $key = str_replace(self::$zip_path, "", $filename);
            $this->zipArchive->addFile($filename, $key);
        }
        return $this->zipArchive->close();
    }

    function addFileList($path, $exception = [])
    {
        $path = substr($path, -1) == '/' ? substr($path, 0, -1) : $path;
        if (is_dir($path)) {
            $dirHandle = opendir($path);
            while (false !== ($fileName = readdir($dirHandle))) {
                $subFile = $path . DIRECTORY_SEPARATOR . $fileName;
                $tmp     = str_replace('.', '', $fileName);
                if (!is_dir($subFile) && $tmp != '' && !in_array($fileName, $exception)) {
                    $this->file_list[] = $subFile;
                } else if (is_dir($subFile) && $tmp != '') {
                    $this->addFileList($subFile, $exception);
                }
            }
            closedir($dirHandle);
        } else {
            $this->file_list[] = $path;
        }
    }


    public function getError()
    {
        return self::$err_info;
    }
}