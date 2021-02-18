<?php

ob_start();

require __DIR__."/vendor/autoload.php";

use CoffeeCode\Router\Router;

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
$route->get('/receber', "App:income");
$route->get('/receber/{status}/{category}/{date}', "App:income");
$route->get('/pagar', "App:expense");
$route->get('/pagar/{status}/{category}/{date}', "App:expense");
$route->get('/fatura/{invoice}', "App:invoice");
$route->post('/onpaid', "App:onpaid");
$route->post('/dash', "App:dash");
$route->post('/invoice', "App:invoice");
$route->get('/invoice/{remove}', "App:invoice");
$route->get('/fixas', 'App:fixes');

$route->get('/perfil', "App:profile");
$route->get("/sair", "App:logout");

$route->post("/launch", "App:launch");
$route->get("/suporte", "App:support");
$route->post("/suporte", "App:support");

$route->post("/filter", "App:filter");

// Group error
$route->group("/error");
$route->get("/{errcode}", "Web:error");

/**
 * This method executes the routes
 */
$route->dispatch();

/*
 * Redirect all errors
 */
if ($route->error()) {
    $route->redirect("/error/{$route->error()}");
}

ob_end_flush();
