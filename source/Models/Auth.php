<?php


namespace Source\Models;


use Source\Core\Model;
use Source\Core\Session;

/**
 * Class Auth
 * @package Source\Models
 */
class Auth extends Model
{
    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["email", "password"], ["id"]);
    }

    /**
     * @param string $email
     * @param string $password
     * @param bool $save
     * @return bool
     */
    public function login(string $email, string $password, bool $save = false): bool
    {
        if (!is_email($email)){
            $this->message->warning("O email informado não é valido!");
            return false;
        }

        if (!is_passwd($password)){
            $this->message->warning("O senha informada não é valido!");
            return false;
        }

        if ($save){
            setcookie("authEmail", $email, time() + 604800, "/");
        } else {
            setcookie("authEmail", null, time() - 3600, "/");
        }

        if (!is_passwd($password)){
            $this->message->warning("A senha informada não é valida");
            return false;
        }

        $user = (new User())->findByEmail($email);
        if (!$user){
            $this->message->error("O e-mail informado não está cadastrado");
            return false;
        }

        if (!passwd_verify($password, $user->password)){
            $this->message->error("A senha informada não confere");
            return false;
        }

        if (passwd_rehash($user->password)){
            $user->password = $password;
            $user->save();
        }

        // LOGIN
        (new Session())->set("authUser", $user->id);
        $this->message->success("Login efetuado com sucesso")->flash();
        return true;

    }

}