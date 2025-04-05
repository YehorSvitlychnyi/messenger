<?php


namespace app\controllers;


use app\core\Response;
use app\core\Route;
use app\core\Session;

class ChatController
{
    /**
     * @return void
     * @throws \Exception
     */
    public function init(): void
    {
        $response = new Response();
        $response->view('chat', [
            'title'  => 'chat',
            'errors' => Session::getErrors(),
        ]);
    }
}