<?php

class QuestionModel extends ModelBase
{
    public function index()
    {
        if (!$this->GET->id) {
            $this->response->redirectExternal('http://gadgetoverflow.ga');
        }
        $question = Repository::question($this->GET->id);
        if (!$question === null) {
            $this->response->redirectExternal('http://gadgetoverflow.ga');
        }
        statics::$question = $question;
        $this->viewModel->set('question', $question);
        $this->viewModel->set('recent', Repository::home(3));
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        return $this->viewModel;
    }

    public function ask()
    {
        return $this->viewModel;
    }
}

?>
