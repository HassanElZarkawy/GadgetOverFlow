<?php

class HomeController extends BaseController
{
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        // if (!User::Instance()->isLogged()) {
        //     $this->response->redirect('account/');
        // }

        require_once("models/home.php");
        $this->model = new HomeModel();
    }
    
    protected function index()
    {
        $this->view->output($this->model->index());
    }
}

?>
