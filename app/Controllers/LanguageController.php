<?php

namespace App\Controllers;

class LanguageController extends Controller {
    
    public function change($request, $response){
        $route = $request->getAttribute('route');
        $lang = $route->getArgument('lang');

        $_SESSION['lang'] = $lang;

        return $response->withRedirect($_SERVER['HTTP_REFERER']);
    }

}
