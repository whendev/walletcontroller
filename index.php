<?php

use CoffeeCode\Router\Router;

require __DIR__."/vendor/autoload.php";

$route = new Router("http://localhost:8080", ":");

$route->namespace("Source\Controllers");
$route->get("/", "Web:home");

// AUTH
$route->get("/entrar", "Web:login");
$route->post("/entrar", "Web:login");

/**
 * ROUTE
 */
$route->dispatch();