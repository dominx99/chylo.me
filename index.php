<?php

session_start();
require_once(__DIR__ . '/vendor/autoload.php');
$config = require_once(__DIR__ . '/app/config.php');

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);
$container = $app->getContainer();

$container['view'] = function($container) use ($config){
    $view = new Slim\Views\Twig('src/views', [
        //'cache' => 'path/to/cache',
    ]);

    $view->addExtension(new Slim\Views\TwigExtension($container->router, $container->request->getUri()));
    $view->getEnvironment()->addGlobal('config', $config);

    return $view;
};

require_once(__DIR__ . '/app/routes.php');

$app->run();
