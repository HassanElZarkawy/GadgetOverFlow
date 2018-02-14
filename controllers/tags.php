<?php

class TagsController extends BaseController
{    
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
        
        require("models/tags.php");
        $this->model = new TagsModel();
    }
    
    protected function index()
    {
        $this->view->output($this->model->index());
    }

    protected function all()
    {
        $this->view->output($this->model->all());
    }
}

?>
