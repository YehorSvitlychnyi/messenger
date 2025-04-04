<?php


namespace app\core;


class Session
{
    /**
     * @param $key
     *
     * @return mixed|null
     */
    static function getItem($key): mixed
    {
        (new Session)->isSessionStart();
        if (empty($_SESSION[$key])) {
            return null;
        }
        return $_SESSION[$key];
    }

    /**
     * @param $key
     * @param $val
     *
     * @return void
     */
    static public function setItem($key, $val): void
    {
        (new Session)->isSessionStart();
        $_SESSION[$key] = $val;
    }

    /**
     * @param array $errors
     *
     * @return void
     */
    static public function setErrors(array $errors): void
    {
        (new Session)->isSessionStart();
        $_SESSION['errors'] = $errors;
    }

    /**
     * @return array|mixed
     */
    static public function getErrors(): mixed
    {
        (new Session)->isSessionStart();
        if (empty($_SESSION['errors'])) {
            return [];
        }
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
        return $errors;
    }

    /**
     * @param $key
     *
     * @return void
     */
    static public function deleteItem($key): void
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