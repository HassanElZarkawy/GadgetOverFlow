<?php

include_once("platform.php");

class ModelBase extends Platform {
    
    protected $viewModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewModel = new ViewModel();
        $this->commonViewData();
    }
    
    protected function commonViewData() {
        
    }    
}

?>