<?php


namespace Source\Controllers;


use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\User;
use Source\Support\Message;

class App extends Controller
{
    private ?User $user;

    public function __construct()
    {
        parent::__construct(__DIR__."/../../themes/".CONF_VIEW_APP."/");

        if (!Auth::user()){
            (new Message())->warning("Você precisa efetuar o login primeiro")->flash();
            redirect("/entrar");
        }

        $this->user = Auth::user();
    }

    public function home()
    {
        var_dump($this->user);
    }

}