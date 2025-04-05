<?php


namespace app\core;

class Request
{
    protected array $request = [];
    /**
     * getting from global array all requests and filtering it
     */
    public function __construct()
    {
        $this->request = $_REQUEST;
        array_walk($this->request, function (&$val) {
            $val = filter_var($val, FILTER_DEFAULT);
        });
    }

    /**
     * getting value from array request by ket($name)
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->request)) {
            return $this->request[$name];
        }
        return null;
    }
}