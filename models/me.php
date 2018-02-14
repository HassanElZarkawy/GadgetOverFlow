<?php

class MeModel extends ModelBase
{
    public function index()
    {
        $this->viewModel->set('me', Repository::user(User::Instance()->Current()->UserId));
        $this->viewModel->set('recent', Repository::home(3));
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        $this->viewModel->set('top', Repository::topUsers());
        return $this->viewModel;
    }

    public function questions()
    {
        $this->viewModel->set('questions', Repository::userQuestions(User::Instance()->Current()->UserId));
        $this->viewModel->set('user', User::Instance()->Current());
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        $this->viewModel->set('recent', Repository::home(3));        
        return $this->viewModel;
    }

    public function edit()
    {
        $this->viewModel->set('me', Repository::user(User::Instance()->Current()->UserId));
        $this->viewModel->set('recent', Repository::home(3));
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        $this->viewModel->set('top', Repository::topUsers());
        return $this->viewModel;
    }
}

?>
