<?php


namespace app\core;

class Request
{
    protected array $request = [];

    public function __construct()
    {
        $this->request = $_REQUEST;
        array_walk($this->request, function (&$val) {
            $val = filter_var($val, FILTER_DEFAULT);
        });
    }

    /**
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