<?php


namespace Source\Controllers;


use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\User;

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
        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->info("Erro ao enviar, favor use o formulario")->render();
                echo json_encode($json);
                return;
            }

            if (request_limit("webregister", 5, 120)){
                $json['message'] = $this->message->info("Você ja fez 5 tentativas, esse é o limite. Por favor, aguarde por 2 minutos para tentar novamente!")->render();
                echo json_encode($json);
                return;
            }

            if (in_array("", $data)){
                $json['message'] = $this->message->info("Informe seus dados para criar sua conta.")->render();
                echo json_encode($json);
                return;
            }

            $data = filter_var_array($data);
            $user = (new User());
            $user->bootstrap($data["first_name"], $data["last_name"], $data["email"], $data["password"]);
            $auth = (new Auth());


            if ($auth->register($user)){
                $json['redirect'] = url("/confirmar");
                echo json_encode($json);
                return;
            } else {
                $json['message'] = $auth->message()->before("Ooops! ")->render();
                echo json_encode($json);
                return;
            }
        }

        echo $this->view->render("auth-register", []);
    }

    public function confirm()
    {
        echo $this->view->render("optin", [
            "data" => (object)[
                "title" => "Falta pouco! Confirme seu cadastro.",
                "desc" => "Enviamos um link de confirmação para seu e-mail. Acesse e siga as instruções para concluir seu cadastro e comece a controlar sua contas! :)",
                "image" => theme("assets/image/mailbox.svg")
            ]
        ]);
    }

    public function success(array $data)
    {
        $email = base64_decode($data['email']);
        $user = (new User())->findByEmail($email);

        if ($user && $user->status != 'confirmed'){
            $user->status = "confirmed";
            $user->save();
        }

        echo $this->view->render("optin", [
            "data" => (object)[
                "title" => "Tudo pronto. Você já pode controlar :)",
                "desc" => "Bem-vindo(a) ao seu controle de contas, vamos começar?",
                "image" => theme("assets/image/Mail_sent.svg"),
                "link" => url("/entrar"),
                "linkTitle" => "Logar-se"
            ]
        ]);
    }

    public function login(?array $data)
    {
        if (Auth::user()){
            redirect("/app");
        }

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

    public function forget(array $data)
    {
        if (!empty($data['csrf'])){
            if (csrf_verify($data['csrf'])){
                $json["message"] = $this->message->warning("Por favor, use o formulario!")->render();
                echo json_encode($json);
                return;
            }

            if (request_repeat("webforget", $data["email"])){
                $json["message"] = $this->message->warning("Você ja tentou este email antes.")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['email'])){
                $json["message"] = $this->message->warning("Você precisa informar seu email para continuar!")->render();
                echo json_encode($json);
                return;
            }

            $auth = (new Auth());
            if ($auth->forget($data["email"])){
                $json["message"] = $this->message->success("Acesse seu email para recuperar sua senha!")->render();
                echo json_encode($json);
                return;
            } else {
                $json["message"] = $auth->message()->render();
                echo json_encode($json);
                return;
            }
        }

        echo $this->view->render("auth-forget", []);
    }

    public function reset(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if (!empty($data['csrf'])){
            if (csrf_verify($data['csrf'])){
                $json["message"] = $this->message->warning("Por favor, use o formulario!")->render();
                echo json_encode($json);
                return;
            }

            if (in_array("", $data)){
                $json['message'] = $this->message->info("Informe sua nova senha para continuar.")->render();
                echo json_encode($json);
                return;
            }

            if ($data["password"] != $data["password_re"]){
                $json['message'] = $this->message->info("As senhas informadas não são iguais!")->render();
                echo json_encode($json);
                return;
            }

            list($email, $code) = explode("|", $data["code"]);
            $auth = (new Auth());
            if ($auth->reset($email, $code, $data["password"])){
                $this->message->success("Senha alterada com sucesso! você ja pode efetuar o login.")->flash();
                $json["redirect"] = url("/entrar");
                echo json_encode($json);
                return;
            } else {
                $json["message"] = $auth->message()->render();
                echo json_encode($json);
                return;
            }
        }

        echo $this->view->render("auth-reset", [
            "code" => $data["code"]
        ]);
    }


    public function error(array $data)
    {

        switch ($data['errcode']){
            case 404:
                echo $this->view->render("error", [
                    "image" => theme("/assets/image/404_error.svg"),
                    "errorTitle" => "ERROR: 404 PAGINA NÃO ENCONTRADA",
                    "errorDescription" => "Desculpe, a página que você está procurando não pode ser acessada.
Verifique o URL"
                ]);
                return;
        }


        echo $this->view->render("error", []);
    }

}