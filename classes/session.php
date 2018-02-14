<?php

class Session
{
    private static $initialized = FALSE;
    private static $sessionID;

    private static function init() {
        if ($initialized) {
            return;
        }
        session_start();
        $initialized = TRUE;
        $sessionID = session_id();
    }

    public static function exists($name) {
        self::init();
        return (isset($_SESSION[$name])) ? TRUE : FALSE;
    }

    public static function put($name, $value, $isArray = FALSE) {
        self::init();
        if(!isset($_SESSION[$name])){
            if($isArray == TRUE){
                $_SESSION[$name] = array();
                foreach ($value as $item) {
                    array_push($_SESSION[$name],$data);
                }
            }
            else{
                $_SESSION[$name] = $value;
            }
        }
    }

    public static function get($name) {
        self::init();
        if(self::exists($name)){
            return $_SESSION[$name];
        } else {
            return null;
        }
    }

    public static function delete($name, $destroy = FALSE) {
        self::init();
        if ($destroy) {
            return session_destroy();
        }
        if (self::exists($name)) {
            unset($_SESSION[$_name]);
            return TRUE;
        }
        return FALSE;
    }

    public static function flash($name, $content = ''){
        self::init();
        if (self::exists($name)){
            $value = self::get($name);
            self::delete($name);
            return $value;
        } else {
            self::put($name, $content);
        }
    }
}

?>