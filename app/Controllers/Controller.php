<?php

namespace App\Controllers;

class Controller {
    protected $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function __get($property){
        return $this->container->{$property};
    }
}
