<?php

class Tokenizer
{
    // public static function generate($name){
    //     return Session::put($name, md5(uniqid()));
    // }
    
    // public static function check($name, $token){
    //     if(Session::exists($name) && $token === Session::get($name)){
    //         Session::delete($name);
    //         return true;
    //     }
    //     return false;
    // }

    public static function exists($name){
        return (isset($_COOKIE[$name])) ? true : false;
    }
    
    public static function put($name, $value, $duration = null) {
        if (!$duration) {
            $duration = 86400 / 24;
        }
        setcookie($name, $value, time() + $duration, "/");
        return $value;
    }
    
    public static function get($name){
        
        if(self::exists($name)){
            return $_COOKIE[$name];
        } else {
            return null;
        }
    }
    
    public static function delete($name){
        if(isset($_COOKIE[$name])){
            unset($_COOKIE[$name]);
            setcookie($name, '', time() - 3600, '/');
        }
    }
    
    public static function flash($name, $content = ''){
        if (self::exists($name)){
            $value = self::get($name);
            self::delete($name);
            return $value;
        } else {
            self::put($name, $content);
        }
    }
}
