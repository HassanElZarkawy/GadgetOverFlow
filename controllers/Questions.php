<?php

class QuestionsController extends BaseController
{    
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        require("models/questions.php");
        $this->model = new QuestionsModel();
    }
    
    protected function recent()
    {
        $this->view->output($this->model->recent());
    }

    protected function mostViewed()
    {
        $this->view->output($this->model->mostViewed());
    }

    protected function mostAnswered()
    {
        $this->view->output($this->model->mostAnswered());
    }
}

?>
