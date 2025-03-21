<?php

namespace app\core;

class Response
{
    public function status(int $statusCode): void
    {
        http_response_code($statusCode);
    }
}