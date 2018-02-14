<?php

class UsersController extends BaseController
{    
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        //create the model object
        require("models/users.php");
        $this->model = new UsersModel();
    }
    
    protected function index()
    {
        $this->view->output($this->model->index());
    }

    protected function profile()
    {
        $this->view->output($this->model->profile());
    }
}

?>
