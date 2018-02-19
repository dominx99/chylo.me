<?php

use PHPMailer\PHPMailer\PHPMailer;

$app->get('/', function($request, $response){
    return $this->view->render($response, 'aboutme.twig');
})->setName('about.me');

$app->get('/umiejetnosci', function($request, $response){
    return $this->view->render($response, 'skills.twig');
})->setName('skills');

$app->get('/kontakt', function($request, $response){
    return $this->view->render($response, 'contact.twig');
})->setName('contact');

$app->post('/email/send', 'EmailController:send')->setName('email.send');

$app->get('/projekty[/{slug}]', function($request, $response){
    $route = $request->getAttribute('route');
    $slug = $route->getArgument('slug');
    $found = null;

    if($slug){
        foreach($this['data']['projects'] as $project){
            if($project['slug'] == $slug){
                $found = $project;
            }
        }
    }

    if($found) {
        return $this->view->render($response, 'project.twig', [
            'project' => $found
        ]);
    }

    return $this->view->render($response, 'projects.twig');
})->setName('projects');

$app->get('/{lang}', 'LanguageController:change')->setName('lang.change');
