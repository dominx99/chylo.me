<?php

$app->get('/', function($request, $response){
    return $this->view->render($response, 'aboutme.twig');
})->setName('about.me');

$app->get('/skills', function($request, $response){
    return $this->view->render($response, 'skills.twig');
})->setName('skills');

$app->get('/app', function(){
    return 'app';
});
