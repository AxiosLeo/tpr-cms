<?php

declare(strict_types=1);

namespace library;

use Filebase\Database;
use Filebase\Filesystem\FilesystemException;
use Filebase\Format\Json;
use Minphp\Session\Session;
use tpr\Config;
use tpr\Container;
use tpr\Path;

class Service
{
    /**
     * @return Session
     */
    public static function session()
    {
        if (!Container::has('session')) {
            Container::bind('session', new Session(null, Config::get('session', [])));
        }

        return Container::get('session');
    }

    /**
     * @param string $name
     *
     * @throws FilesystemException
     *
     * @return Database
     */
    public static function filedb($name)
    {
        $container = 'filedb.' . $name;
        if (!Container::has($container)) {
            $config = Config::get('db.' . $name, [
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
                        'valid.required' => true,
                    ],
                ],
            ]);
            Container::bind($container, new Database($config));
        }

        return Container::get($container);
    }
}
