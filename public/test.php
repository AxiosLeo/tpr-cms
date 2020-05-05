<?php

declare(strict_types=1);

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

require_once __DIR__ . '/../vendor/autoload.php';

$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();
//
//$test = require './func.php';
//
////$testFunc = function ($a)
////{
////    return $a . "-test";
////};
////
//$base = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'views';
//
//$template_loader = new Environment(new FilesystemLoader($base), [
//    'ext'   => 'html',
//    'base'  => $base,
//    'cache' => __DIR__ . '/.cache/'
//]);
//
//foreach ($test as $name => $func) {
//    $template_loader->addFunction(new TwigFunction('testFunc', $func));
//}
//
////dump($template_loader->getFunctions());
//
//$html = $template_loader->render('index/index/index.html', [
//    'title'    => 'title',
//    'listItem' => [
//        [
//            'name'  => 'test',
//            'value' => '1'
//        ]
//    ]
//]);

//echo $html;

$data = [
    'a' => 1,
    'b' => [
        'c' => 2,
    ],
];

file_put_contents(__DIR__ . '/tmp.php', "<?php\nreturn " . var_export($data, true) . ";\n");
