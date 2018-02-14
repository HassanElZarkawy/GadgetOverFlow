<?php

class UserController extends BaseController
{
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        // if (!User::Instance()->isLogged()) {
        //     $this->response->redirectExternal('http://gadgetoverflow.ga/account/login');
        // }

        require_once("models/user.php");
        $this->model = new UserModel();
    }

    protected function index()
    {
        $this->view->output($this->model->index());
    }

    protected function questions()
    {
        $this->view->output($this->model->questions());
    }
}

?>
