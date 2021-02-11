<?php


namespace Source\Controllers;


use Source\Core\Controller;

/**
 * Class Web
 * @package Source\Controllers
 */
class Web extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__."/../../themes/".CONF_VIEW_THEME."/");
    }


    public function home()
    {
        echo $this->view->render("home", []);
    }
}