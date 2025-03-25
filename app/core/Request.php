<?php


namespace app\core;

class Request
{
    protected $request = [];

    public function __construct()
    {
        $this->request = $_REQUEST;
        array_walk($this->request, function (&$val){
            $val = filter_var($val, FILTER_DEFAULT);
        });
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->request)){
            return $this->request[$name];
        }
        return null;
    }

}