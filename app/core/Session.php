<?php


namespace app\core;


class Session
{
    static function getItem($key){
        session_start();
        if(empty($_SESSION[$key])){
            return null;
        }
        return $_SESSION[$key];
    }

    static public function setItem($key, $val){
        session_start();
        $_SESSION[$key] = $val;
    }

    static public function setErrors(array $errors){
        session_start();
        $_SESSION['errors'] = $errors;
    }

    static public function getErrors(){
        session_start();
        if(empty($_SESSION['errors'])){
            return [];
        }
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
        return $errors;
    }

}