<?php

session_start();

require_once(__DIR__ . '/vendor/autoload.php');
$app = new Slim\App();
require_once(__DIR__ . '/app/routes.php');

$container = $app->getContainer();

$app->run();
