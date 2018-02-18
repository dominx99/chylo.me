<?php

namespace App\Controllers;

class LanguageController extends Controller {

    public function __construct($container){
        parent::__construct($container);

        $this->container['lang'] = $this->container['config']['lang'];

        if(isset($_SESSION['lang']))
            $this->container['lang'] = $_SESSION['lang'];
    }

    public function change($request, $response){
        $route = $request->getAttribute('route');
        $lang = $route->getArgument('lang');

        $_SESSION['lang'] = $lang;


        return $response->withRedirect($_SERVER['HTTP_REFERER']);
    }

    public static function handle($string){
        return $string;
    }

}
