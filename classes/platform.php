<?php


class Platform {
    protected $database;
    protected $POST;
    protected $GET;
    protected $response;
    protected $client;
    
    public function __construct()
    {
        $this->database = DbContext::getInstance();
        $this->POST = Utility::Objectify($_POST);
        $this->GET = Utility::Objectify($_GET);
        $this->response = new Response();
        $this->client = new Client();
    }
    
    public function safeExecute($function, $throw = FALSE) {
        try {
            if (isset($function)) {
                $function();
            }
        } catch (Exception $e) {
            if ($throw) {
                throw $e;
            }
        }
    }
}
?>