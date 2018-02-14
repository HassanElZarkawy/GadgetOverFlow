<?php

include_once("platform.php");

class BaseController extends Platform {
    
    protected $urlValues;
    protected $action;
    protected $model;
    protected $view;

    public function __construct($action, $urlValues) {
        parent::__construct();
        $this->action = $action;
        $this->urlValues = $urlValues;
        $this->view = new View(get_class($this), $action);
    }
    
    public function executeAction() {
        return $this->{$this->action}();
    }
    
    
}

?>