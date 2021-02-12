<?php


namespace Source\Controllers;


use Source\Core\Controller;
use Source\Models\Auth;
use Source\Support\Message;

class App extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__."/../../themes/".CONF_VIEW_APP."/");

        if (!Auth::user()){
            (new Message())->warning("Você precisa efetuar o login primeiro")->flash();
            redirect("/entrar");
        }
    }

    public function home()
    {
        echo "olá";
    }

}