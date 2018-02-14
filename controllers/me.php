<?php

class MeController extends BaseController
{
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        if (!User::Instance()->isLogged()) {
            $this->response->redirectExternal('http://gadgetoverflow.ga/account/login');
        }

        require_once("models/me.php");
        $this->model = new MeModel();
    }
    
    protected function index()
    {
        $this->view->output($this->model->index());
    }

    protected function questions()
    {
        $this->view->output($this->model->questions());
    }

    protected function edit()
    {
        $this->view->output($this->model->edit());
    }

    protected function update()
    {
        $obj = $this->POST;
        
        // if (!preg_match("/^[a-zA-Z ]*$/", $obj->DisplayName)) {
        //   Tokenizer::put('update-error', '"Display Name" Only letters and white spaces allowed. Please try again');
        //   return $this->response->redirectExternal('http://gadgetoverflow.ga/me/edit'); 
        // }
        if (!filter_var($obj->Email, FILTER_VALIDATE_EMAIL)) {
          Tokenizer::put('update-error', '"Email" Invalid Email address. Please try again');
          return $this->response->redirectExternal('http://gadgetoverflow.ga/me/edit');  
        }
        $userId = User::Instance()->Current()->UserId;
        $this->database->query('UPDATE User SET DisplayName = ?, Email = ? WHERE UserId = ?', array($obj->DisplayName, $obj->Email, $userId));
        $this->database->query('UPDATE UserInfo SET Country = ?, Website = ?, Description = ? WHERE UserId = ?', array($obj->Country, $obj->Website, $obj->Description, $userId));
        return $this->response->redirectExternal('http://gadgetoverflow.ga/me');
    }
}
?>