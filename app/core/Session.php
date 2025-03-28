<?php


namespace app\core;


class Session
{
    static function getItem($key){
        (new Session)->isSessionStart();
        if(empty($_SESSION[$key])){
            return null;
        }
        return $_SESSION[$key];
    }

    static public function setItem($key, $val){
        (new Session)->isSessionStart();
        $_SESSION[$key] = $val;
    }

    static public function setErrors(array $errors){
        (new Session)->isSessionStart();
        $_SESSION['errors'] = $errors;
    }

    static public function getErrors(){
        (new Session)->isSessionStart();
        if(empty($_SESSION['errors'])){
            return [];
        }
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
        return $errors;
    }
    static public function deleteItem($key)
    {
        (new Session)->isSessionStart();
        unset($_SESSION[$key]);
    }

    /**
     * @return void
     */
    private function isSessionStart(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}

//static private function isSessionStart(): void
//{
//    if (session_status() !== PHP_SESSION_ACTIVE) {
//        session_start();
//    }
//}

//static public function setItem($key, $val){
//    self::isSessionStart();
//    $_SESSION[$key] = $val;
//}