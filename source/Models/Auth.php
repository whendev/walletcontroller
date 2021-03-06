<?php


namespace Source\Models;


use Source\Core\Model;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\WalletApp\AppWallet;
use Source\support\Email;


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
     * @return User|null
     */
    public static function user(): ?User
    {
        $session = new Session();
        if (!$session->has("authUser")) {
            return null;
        }
        return (new User())->findById($session->authUser);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function register(User $user): bool
    {
        if(!$user->save()){
            $this->message = $user->message;
            return false;
        }

        $user_id = (new User())->findByEmail($user->email);

        (new AppWallet())->create([
            "user_id" => $user_id->id,
            "wallet" => "Carteira demo"
        ]);

        $view = new View(__DIR__."/../../shared/views/email");
        $message = $view->render("confirm", [
            "first_name" => $user->first_name,
            "confirm_link" => url("/obrigado/". base64_encode($user->email))
        ]);

        (new Email())->bootstrap("Ative sua conta no ". CONF_SITE_NAME,
            $message,
            $user->email,
            "{$user->first_name} {$user->last_name}"
        )->send();

        return true;
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

        if ($save) {
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

    /**
     * @param string $email
     * @return bool
     */
    public function forget(string $email): bool
    {
        if (!is_email($email)){
            $this->message->error("O email informado não é valido!");
            return false;
        }

        $user = (new User())->findByEmail($email);
        if (!$user){
            $this->message->error("O email informado não está cadastrado!");
            return false;
        }

        $user->forget = md5(uniqid(rand()));
        $user->save();

        $email = (new View(__DIR__."/../../shared/views/email"))->render(
          "forget",
          [
              "first_name" => $user->first_name,
              "forget_link" => url("/recuperar/{$user->email}|{$user->forget}")
          ]
        );

        (new Email())->bootstrap(
            "Recupere sua senha no  ". CONF_SITE_NAME,
            $email,
            $user->email,
            "{$user->first_name} {$user->last_name}"
        )->send();

        return true;
    }

    /**
     * @param string $email
     * @param string $code
     * @param string $password
     * @return bool
     */
    public function reset(string $email, string $code, string $password): bool
    {
        if (!is_email($email)){
            $this->message->error("O email informado não é valido!");
            return false;
        }

        $user = (new User())->findByEmail($email);
        if (!$user){
            $this->message->error("O email informado não está cadastrado!");
            return false;
        }

        if ($user->forget != $code){
            $this->message->error("O codigo informado não é valido!");
            return false;
        }

        $user->password = $password;
        $user->forget = null;
        if ($user->save()){
            return true;
        } else {
            $this->message = $user->message();
            return false;
        }
    }


}