<?php

class TagsModel extends BaseModel
{    
    public function index()
    {
        $this->viewModel->set("tags", Repository::advTags());
        return $this->viewModel;
    }

    public function all()
    {
        if ($_GET['id'] === null || !isset($_GET['id'])) {
            $this->response->redirectExteranl('http://gadgetoverflow.ga/error/badUrl');
        }
        $this->viewModel->set("details", Repository::tagDetails($_GET['id']));
        $this->viewModel->set('stats', Repository::stats());
        $this->viewModel->set('tags', Repository::tags(6, 0));
        return $this->viewModel;
    }
}

?>
