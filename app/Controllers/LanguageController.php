<?php

namespace App\Controllers;

class LanguageController extends Controller {

    public function change($request, $response){
        $route = $request->getAttribute('route');
        $lang = $route->getArgument('lang');

        if(in_array($lang, $this->container['acceptLanguages']))
            $_SESSION['lang'] = $lang;

        if(isset($_SERVER['HTTP_REFERER']))
            return $response->withRedirect($_SERVER['HTTP_REFERER']);

        return $response->withRedirect($this->router->pathFor('about.me'));
    }

}
