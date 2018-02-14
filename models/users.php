<?php

class UsersModel extends BaseModel
{    
    public function index()
    {
        $this->viewModel->set('users', Repository::users());
        return $this->viewModel;
    }

    public function profile()
    {
        if ($_GET['id'] === null || !isset($_GET['id'])) {
            $this->response->redirectExteranl('http://gadgetoverflow.ga/error/badUrl');
        }
        $this->viewModel->set('recent', Repository::home(3));
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        $this->viewModel->set('top', Repository::topUsers());
        $this->viewModel->set('user', Repository::user($_GET['id']));
        return $this->viewModel;
    }
}

?>
