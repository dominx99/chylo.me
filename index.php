<?php

session_start();
require_once(__DIR__ . '/vendor/autoload.php');

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);
$container = $app->getContainer();

$container['path'] = __DIR__;

$dotenv = new \Dotenv\Dotenv($container->path);
$dotenv->load();


$container['config'] = function($container){
    return $config = require_once(__DIR__ . '/app/config.php');
};

$container['data'] = function($container){
    return json_decode(file_get_contents(__DIR__ . '/app/data.json'), true);
};

$container['view'] = function($container){
    $view = new Slim\Views\Twig('views', [
        //'cache' => 'path/to/cache',
    ]);

    $view->addExtension(new Slim\Views\TwigExtension($container->router, $container->request->getUri()));
    $view->getEnvironment()->addGlobal('config', $container->config);
    $view->getEnvironment()->addGlobal('data', $container->data);

    return $view;
};

$container['validator'] = function($container){
    return new App\Validation\Validator;
};

$container['EmailController'] = function($container){
    return new App\Controllers\EmailController($container);
};

$app->add(new App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new App\Middleware\OldInputMiddleware($container));

require_once(__DIR__ . '/app/routes.php');

$app->run();
