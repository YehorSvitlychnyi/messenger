<?php


namespace app\controllers;


use app\core\Response;
use app\core\Route;
use app\core\Session;

class ChatController
{
    public function init(){
        $response = new Response();
        $response->view('chat', [
            'title' => 'chat',
            'errors' => Session::getErrors(),
        ]);
    }
}