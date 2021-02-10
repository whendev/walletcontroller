<?php


namespace Source\support;


class Message
{
    private string $type = "";
    private string $text = "";


    public function __toString(): string
    {
        return $this->render();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getType(): string
    {
        return $this->type;
    }


    public function error(string $message)
    {
        $this->type = CONF_MESSAGE_ERROR;
        $this->text = $message;
        return $this;
    }
    public function warning(string $message)
    {
        $this->type = CONF_MESSAGE_WARNING;
        $this->text = $message;
        return $this;
    }
    public function info(string $message)
    {
        $this->type = CONF_MESSAGE_INFO;
        $this->text = $message;
        return $this;
    }
    public function success(string $message)
    {
        $this->type = CONF_MESSAGE_SUCCESS;
        $this->text = $message;
        return $this;
    }

    public function render(): string
    {
        return "<div class='".CONF_MESSAGE_CLASS." {$this->type}'>
                   {$this->text}
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                  </button>
                </div>";
    }


}