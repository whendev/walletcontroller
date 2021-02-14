<?php


namespace Source\Models;


use Source\Core\Model;

/**
 * Class User
 * @package Source\Models
 */
class User extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["first_name", "last_name", "email", "password"], ["id"]);
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string|null $document
     * @return $this
     */
    public function bootstrap(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $document = null
    ): User {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->document = $document;
        return $this;
    }

    /**
     * @param string $email
     * @param string $columns
     * @return User|null
     */
    public function findByEmail(string $email, string $columns = "*"): ?User
    {
        return $this->find("email = :email", "email={$email}", $columns)->fetch();
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()){
            $this->message->warning("Por favor, preencha todos os dados e tente novamente!");
            return false;
        }

        if (!is_email($this->email)){
            $this->message->warning("O e-mail informado não tem um formato valido");
            return false;
        }

        if (!is_passwd($this->password)){
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("Sua senha deve ter entre {$min} a {$max} caracteres");
            return false;
        } else {
            $this->password = passwd($this->password);
        }

        // UPDATE
        if (!empty($this->id)){
            $userId = $this->id;
            if ($this->find("email = :email AND id != :id", "email={$this->email}&id={$userId}", "id")->fetch()){
                $this->message->error("O email informado já está cadastrado!");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()){
                $this->message->error("Erro ao atualizar, verifique os dados e tente novamente. Caso o erro persista, contacte nosso suporte. ");
                return false;
            }
        }

        $userId = $this->id;

        // CREATE
        if (empty($this->id)){
            if ($this->findByEmail($this->email, "id")){
                $this->message->error("O email informado já está cadastrado!");
                return false;
            }

            $userId = $this->create($this->safe());
            if ($this->fail()){
                $this->message->error("Erro ao salvar, verifique os dados e tente novamente. Caso o erro persista, contacte nosso suporte. ");
                return false;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return true;
    }
}