<?php

class SitemapModel extends ModelBase
{    
    public function index()
    {
        $count = $this->database->query('SELECT COUNT(*) AS Count FROM Questions')->first()->Count;
        return $this->viewModel;
    }
}

?>
