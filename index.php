<?php

session_start();
require_once(__DIR__ . '/vendor/autoload.php');

ini_set('session.gc_divisor', 1);
ini_set('session.gc_probability', 1);
ini_set('session.gc_maxlifetime', 5*24*60*60);

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

$container = $app->getContainer();

$container['path'] = __DIR__;

$dotenv = new \Dotenv\Dotenv($container->path . '/config');
$dotenv->load();

//CONFIG

$container['config'] = function($container){
    return $config = require_once(__DIR__ . '/app/config.php');
};

//LANGUAGE

$container['acceptLanguages'] = function($container){
    return [
        'pl', 'en'
    ];
};

$container['LanguageController'] = function($container){
    return new App\Controllers\LanguageController($container);
};

//VIEW

$container['view'] = function($container){
    $view = new Slim\Views\Twig('views', [
        //'cache' => 'path/to/cache',
    ]);

    $view->addExtension(new Slim\Views\TwigExtension($container->router, $container->request->getUri()));
    $view->getEnvironment()->addGlobal('config', $container->config);

    return $view;
};

//VALIDATOR

$container['validator'] = function($container){
    return new App\Validation\Validator;
};

//EMAILS

$container['EmailController'] = function($container){
    return new App\Controllers\EmailController($container);
};

//MIDDLEWARES

$app->add(new App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new App\Middleware\OldInputMiddleware($container));
$app->add(new App\Middleware\DataReplaceMiddleware($container));

require_once(__DIR__ . '/app/routes.php');

$app->run();
