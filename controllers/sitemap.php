<?php

class SitemapController extends BaseController
{
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
    }

    protected function index()
    {
        $db = DbContext::getInstance();
        if ($this->GET->id == NULL) {
            $count = $db->query('SELECT COUNT(*) AS Count FROM Questions')->first()->Count;
            $this->createIndex($count);
        } else {
            $skip = $this->GET->id * 1000;
            $all = $db->query("SELECT Id FROM Questions OFFSET LIMIT $skip, 1000")->results();
            $this->createItems($all);
        }
        
    }

    private function createIndex($count)
    {
        $iter = floor($count / 1000);
        header ('Content-type: text/xml');
        echo'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        for ($i = 0; $i < $iter; $i++) {
            echo '<sitemap>';
            echo '  <loc>' . 'http://gadgetoverflow.ga/sitemap/' . $i . '</loc>';
            echo '  <lastmod>' . date('Y-m-d') . '</lastmod>';
            echo '</sitemap>';
        }
        echo '</sitemapindex>';
        die();
    }

    private function createItems($items)
    {
        header ('Content-type: text/xml');
        echo'<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
        echo'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        foreach ($items as $item) {
            echo '<url>';
            echo '  <loc>http://gadgetoverflow.ga/question/' . $item->Id . '</loc>';
            echo '  <changefreq>weekly</changefreq>';
            echo '</url>';
        }
        echo '</urlset>';
        die();
    }
}

?>
