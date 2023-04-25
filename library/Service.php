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
            Container::bindWithObj('session', new Session(null, Config::get('session', [])));
        }

        return Container::get('session');
    }

    /**
     * @param string $name
     *
     * @return Database
     *
     * @throws FilesystemException
     */
    public static function filedb($name)
    {
        $container = 'filedb.' . $name;
        if (!Container::has($container)) {
            $config = Config::get('db.' . $name, [
                'dir'            => path_join(Path::root(), 'datas/' . $name),
                'backupLocation' => path_join(Path::root(), 'datas/backup/' . $name),
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
            Container::bindWithObj($container, new Database($config));
        }

        return Container::get($container);
    }
}
