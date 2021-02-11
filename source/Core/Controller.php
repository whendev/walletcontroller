<?php


namespace Source\Core;



use Source\support\Message;

/**
 * Class Controller
 * @package Source\Core
 */
class Controller
{

    protected View $view;
    protected Message $message;

    /**
     * Controller constructor.
     * @param string|null $pathToViews
     */
    public function __construct(string $pathToViews = null)
    {
        $this->message = new Message();
        $this->view = new View($pathToViews);
    }

}