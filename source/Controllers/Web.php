<?php


namespace Source\Controllers;


use Source\Core\Controller;
use Source\Models\Auth;

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

    public function register(?array $data)
    {
        echo $this->view->render("auth-register", []);
    }

    public function login(?array $data)
    {
        if (!empty($data['csrf'])){
            if (!csrf_verify($data)){
                $json['message'] = $this->message->info("Erro ao enviar, favor use o formulario")->render();
                echo json_encode($json);
                return;
            }

            if (request_limit("weblogin", 3, "120")){
                $json['message'] = $this->message->info("Você ja fez 3 tentativas, esse é o limite. Por favor, aguarde por 2 minutos para tentar novamente!")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['email']) || empty($data['password'])){
                $json['message'] = $this->message->warning("Favor, é necessario preencher os campos abaixo")->render();
                echo json_encode($json);
                return;
            }

            $save = (!empty($data['save']) ? true : false);
            $auth = new Auth();
            $login = $auth->login($data['email'], $data['password'], $save);

            if ($login){
                $json['redirect'] = url("/app");
                echo json_encode($json);
                return;
            } else {
                $json['message'] = $auth->message()->before("Ooops! ")->render();
                echo json_encode($json);
                return;
            }
        }

        echo $this->view->render("auth-login", [
            "cookie" => filter_input(INPUT_COOKIE , "authEmail")
        ]);
    }
}