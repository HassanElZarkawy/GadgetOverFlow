<?php

class HomeModel extends ModelBase
{
    public function index()
    {
        $this->viewModel->set('questions', Repository::home(21));
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        $this->viewModel->set('top', Repository::topUsers());
        return $this->viewModel;
    }
}

?>
