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

$app->post('/email/send', function($request, $response){

    $dotenv = new Dotenv\Dotenv($this->path);
    $dotenv->load();

    $params = $request->getParams();

    $mail = new PHPMailer;
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['GMAIL_LOGIN'];
    $mail->Password = $_ENV['GMAIL_PASSWORD'];
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Host = "tls://smtp.gmail.com:587";
    $mail->setFrom($params['from'], $params['from']);
    $mail->addReplyTo($params['from']);
    $mail->addAddress($_ENV['GMAIL_LOGIN'], 'Dominik');

    $mail->Subject = $params['subject'];
    $mail->Body = $params['body'];

    $mail->send();

    return $response->withRedirect($this->router->pathFor('contact'));

})->setName('email.send');

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
