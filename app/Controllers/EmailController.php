<?php

namespace App\Controllers;

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use Respect\Validation\Validator as v;

class EmailController extends Controller {

    protected $mail;

    public function __construct($container){
        parent::__construct($container);

        $this->mail = new PHPMailer;
        $this->SMTPDebug = 2;
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['GMAIL_LOGIN'];
        $this->mail->Password = $_ENV['GMAIL_PASSWORD'];
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 587;
        $this->mail->Host = "tls://smtp.gmail.com:587";
    }

    public function send($request, $response){

        $validation = $this->validator->validate($request, [
            'from' => v::email(),
            'subject' => v::notEmpty(),
            'body' => v::notEmpty()
        ]);

        if($validation->failed())
            return $response->withRedirect($this->router->pathFor('contact'));

        unset($_SESSION['old']);

        $params = $request->getParams();

        $this->mail->setFrom($params['from'], $params['from']);
        $this->mail->addReplyTo($params['from']);
        $this->mail->addAddress($_ENV['GMAIL_ADDRESS'], 'Dominik');

        $this->mail->Subject = $params['subject'];
        $this->mail->Body = $params['body'];

        $this->mail->send();

        return $response->withRedirect($this->router->pathFor('contact'));
    }
}
