<?php

session_start();
require_once(__DIR__ . '/vendor/autoload.php');

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);
$container = $app->getContainer();

$container['config'] = function($container){
    return $config = require_once(__DIR__ . '/app/config.php');
};

$container['data'] = function($container){
    return json_decode(file_get_contents(__DIR__ . '/src/config.json'), true);
};

$container['view'] = function($container){
    $view = new Slim\Views\Twig('src/views', [
        //'cache' => 'path/to/cache',
    ]);

    $view->addExtension(new Slim\Views\TwigExtension($container->router, $container->request->getUri()));
    $view->getEnvironment()->addGlobal('config', $container->config);
    $view->getEnvironment()->addGlobal('data', $container->data);

    return $view;
};

require_once(__DIR__ . '/app/routes.php');

$app->run();
