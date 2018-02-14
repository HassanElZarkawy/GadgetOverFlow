<?php

class QuestionsModel extends BaseModel
{    
    public function mostViewed()
    {
        $this->viewModel->set('questions', Repository::mostViewed());
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        return $this->viewModel;
    }

    public function mostAnswered()
    {
        $this->viewModel->set('questions', Repository::mostAnswered());
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        return $this->viewModel;
    }

    public function recent()
    {
        $this->viewModel->set('new', Repository::home());
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        return $this->viewModel;
    }
}

?>
