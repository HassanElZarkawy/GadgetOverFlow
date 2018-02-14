<?php

class UserModel extends ModelBase
{
    public function index()
    {
        $this->viewModel->set('user', Repository::user($this->GET->id));
        $this->viewModel->set('recent', Repository::home(3));
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        $this->viewModel->set('top', Repository::topUsers());
        return $this->viewModel;
    }

    public function questions()
    {
        $this->viewModel->set('questions', Repository::userQuestions($this->GET->id));
        $this->viewModel->set('user', Repository::user($this->GET->id));
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        return $this->viewModel;
    }
}

?>
