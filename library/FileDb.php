<?php

declare(strict_types = 1);

namespace library;

use Filebase\Database;
use Filebase\Filesystem\FilesystemException;
use Filebase\Format\Json;
use tpr\Config;
use tpr\Path;

class FileDb
{
    /**
     * @var Database[]
     */
    private static $client = [];

    private static $curr = '';

    /**
     * @param string $name
     *
     * @return Database
     * @throws FilesystemException
     */
    public static function client($name = 'default')
    {
        if (!isset(self::$client[$name])) {
            self::$client[$name] = new Database(self::getDbConfig($name));
        }
        self::$curr = $name;
        return self::$client[$name];
    }

    public static function getDbConfig($name)
    {
        $default = [
            'dir'            => Path::root() . 'datas/' . $name,
            'backupLocation' => Path::root() . 'datas/backup/' . $name,
            'format'         => Json::class,
            'cache'          => true,
            'cache_expires'  => 1800,
            'pretty'         => true,
            'safe_filename'  => true,
            'read_only'      => false,
            'validate'       => [
                'name' => [
                    'valid.type'     => 'string',
                    'valid.required' => true
                ]
            ]
        ];
        $config  = Config::get('db', []);

        return array_merge($default, $config);
    }
}
