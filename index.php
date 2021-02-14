<?php

use CoffeeCode\Router\Router;

require __DIR__."/vendor/autoload.php";

$route = new Router("http://localhost:8080", ":");

$route->namespace("Source\Controllers");
$route->get("/", "Web:home");

// AUTH
$route->get("/entrar", "Web:login");
$route->post("/entrar", "Web:login");

$route->get("/cadastrar", "Web:register");
$route->post("/cadastrar", "Web:register");

$route->get("/recuperar", "Web:forget");
$route->post("/recuperar", "Web:forget");

$route->get("/recuperar/{code}", "Web:reset");
$route->post("/recuperar/resetar", "Web:reset");

// MAIL
$route->get("/confirmar", "Web:confirm");
$route->get("/obrigado/{email}", "Web:success");


// APP
$route->group("/app");
$route->get("/", "App:home");



/**
 * ROUTE
 */
$route->dispatch();