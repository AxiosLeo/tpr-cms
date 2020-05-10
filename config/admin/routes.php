<?php

declare(strict_types=1);

// @see : https://github.com/nikic/FastRoute
return [
    'home'  => [
        'rule'         => '/test[/{title}]',
        'method'       => 'GET',
        'handler'      => 'admin\\index\\controller\\Index::index',
        'requirements' => [],
    ],
    'login' => [
        'rule'    => '/login',
        'method'  => 'GET',
        'handler' => 'admin\\user\\controller\\Index::login',
    ],
];
