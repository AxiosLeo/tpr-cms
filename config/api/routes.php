<?php

/**
 * @see : https://github.com/nikic/FastRoute
 */
return [
    'route_name' => [
        'rule'         => '/index/{id:\\d+}[/{title}]',
        'method'       => 'GET',
        'handler'      => 'App\\index\\controller\\Index::param',
        'requirements' => [],
    ],
];
