<?php

class User
{
    private $_db,
    $_data;
    
    private static $_instance = null;
    
    public function __construct($id = null){
        $this->_db = DbContext::getInstance();
    }
    
    public static function Instance()
    {
        if(!isset(self::$_instance)){
            self::$_instance = new User();
        }
        return self::$_instance;
    }
    
    public function find($username){
        if($username){
            $data = $this->_db->query('SELECT * FROM User WHERE Username = ? OR Email = ?', array($username, $username))->first();
            if($data !== null){
                $this->_data = $data;
                return true;
            }
        }
        return false;
    }
    
    public function login($username = null, $password = null){
        $success = $this->find($username);
        if($success){
            if($this->data()->Password === $password){
                $userID = $this->data()->UserId;
                Tokenizer::put('userId', $userID);
                return true;
            }
        }
        return false;
    }
    
    public function isLogged(){
        $id = Tokenizer::get('userId');
        if($id !== null){
            return  true;
        }
        return false;
    }

    public function logout() {
        Tokenizer::delete('userId');
    }
    
    public function Current() {
        if (!$this->isLogged()) {
            return null;
        }
        if ($this->_data !== null) {
            return $this->_data;
        }
        $id = Tokenizer::get('userId');
        $this->_data = $this->_db->query("SELECT * FROM User WHERE UserId = ?", array($id))->first();
        return $this->_data;
    }
    
    public function data(){
        return $this->_data;
    }
}