<?php

session_start();
require_once(__DIR__ . '/vendor/autoload.php');
$config = require_once(__DIR__ . '/app/config.php');

$app = new Slim\App();
$container = $app->getContainer();

require_once(__DIR__ . '/app/routes.php');

$container['view'] = function($container) use ($config){
    $view = new Slim\Views\Twig('src\views', [
        //'cache' => 'path/to/cache',
    ]);

    $basePath = rtrim(str_replace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->getEnvironment()->addGlobal('config', $config);

    return $view;
};

$app->run();
