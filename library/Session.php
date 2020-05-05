<?php

declare(strict_types = 1);

namespace library;

use tpr\Container;

class Session
{
    /**
     * @return \Minphp\Session\Session
     */
    public static function instance()
    {
        if (!Container::has('session')) {
            Container::bind('session', new \Minphp\Session\Session());
        }
        return Container::get('session');
    }
}
