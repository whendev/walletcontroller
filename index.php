<?php

use CoffeeCode\Router\Router;

require __DIR__."/vendor/autoload.php";


$router = new Router("http://localhost:8080/");

$router->get("/", function (){
    echo "tudo ok";
});

/**
 * ROUTE
 */
$router->dispatch();