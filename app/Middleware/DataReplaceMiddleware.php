<?php

namespace App\Middleware;

class DataReplaceMiddleware extends Middleware {

    public function __invoke($request, $response, $next){
        try {
            $languages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            $lang = explode(',', $languages)[0];

            if(isset($_SESSION['lang']))
                $lang = $_SESSION['lang'];

        } catch (Exception $e) {
            $lang = $this->container['config']['lang'];
        }

        switch($lang){
            case "pl-PL": $lang = 'pl'; break;
            case "en-US": $lang = 'en'; break;
        }

        if(!in_array($lang, $this->container['acceptLanguages']))
            $lang = 'en';

        $this->container->view->getEnvironment()->addGlobal('lang', $lang);

        $then = date_create(date('Y-m-d', strtotime('2015-09-01')));
        $now = date_create(date('Y-m-d'));
        $diff = date_diff($now, $then);

        $regex = [
            '~{years}~' => function($matches) use ($diff){
                return floor(($diff->days / 365));
            },
            '~{year}~' => function($matches){
                return date('Y');
            }
        ];

        $array = json_decode(file_get_contents($this->container['path'] . '/app/data_'.$lang.'.json'), true);

        array_walk_recursive($array, function(&$item, $key) use ($regex){
            $item = preg_replace_callback_array($regex, $item);
        });

        $this->container['data'] = $array;
        $this->container->view->getEnvironment()->addGlobal('data', $array);

        return $next($request, $response);
    }

}
