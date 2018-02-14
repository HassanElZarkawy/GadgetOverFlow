<?php

class RSSController extends BaseController
{    
    public function __construct($action, $urlValues) {
        parent::__construct($action, $urlValues);
    }
    
    protected function index()
    {
        $home = Repository::home();
        foreach ($home as $item) {
            unset($item->Password,$item->Username,$item->Email);
        }
        $this->response->xmlResponse($this->createXML($home));
    }

    private function createXML($obj) 
    {
        $rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
        $rssfeed .= '<rss version="2.0">';
        $rssfeed .= '<channel>';
        $rssfeed .= '<title>My RSS feed</title>';
        $rssfeed .= '<link>http://www.gadgetoverflow.ga</link>';
        $rssfeed .= '<description>Gadget Overflow RSS feed</description>';
        $rssfeed .= '<language>en-us</language>';
        $rssfeed .= '<copyright>Copyright (C) 2017 Gadget Overflow</copyright>';

        if (!is_array($obj)) {
            $rssfeed .= "<item>";
            $rssfeed .= "<title>" . $obj->Title . "</title>";
            $rssfeed .= "<description> <![CDATA[" . $obj->Body . "]]> </description>";
            $rssfeed .= "<link>" . "http://gadgetoberflow.ga/question/" . $obj->Id . "</link>";
            $rssfeed .= "<pubDate>" . date("D, d M Y H:i:s O", $obj->CreationDate) . "</pubDate>";
            $rssfeed .= "<item>";
        } else {
            foreach ($obj as $item) {
                $rssfeed .= "<item>";
                $rssfeed .= "<title>" . $item->Title . "</title>";
                $rssfeed .= "<description> <![CDATA[" . $item->Body . "]]> </description>";
                $rssfeed .= "<link>" . "http://gadgetoberflow.ga/question/" . $item->Id . "</link>";
                $rssfeed .= "<pubDate>" . date("D, d M Y H:i:s O", $item->CreationDate) . "</pubDate>";
                $rssfeed .= "<item>";
            }
        }
        $rssfeed .= '</channel>';
        $rssfeed .= '</rss>';
        return $rssfeed;
    }
}

?>
