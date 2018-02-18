<?php

namespace App\Middleware;

class DataReplaceMiddleware extends Middleware {

    public function __invoke($request, $response, $next){

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

        $array = json_decode(file_get_contents($this->container['path'] . '/app/data_'.$this->container['lang'].'.json'), true);

        array_walk_recursive($array, function(&$item, $key) use ($regex){
            $item = preg_replace_callback_array($regex, $item);
        });

        $this->container['data'] = $array;
        $this->container->view->getEnvironment()->addGlobal('data', $array);

        return $next($request, $response);
    }

}
