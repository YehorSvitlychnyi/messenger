<?php


namespace app\controllers;


use app\core\Request;
use app\core\Response;
use app\models\ChatModel;

class ApiController
{
    public $response;
    public $model;
    public $request;

    public function __construct()
    {
        $this->response = new Response();
        $this->model = new ChatModel();
        $this->request = new Request();
    }

    public function getchats()
    {
        $chats = $this->model->getChats();
        $this->response->json($chats);
    }
    public function getMessages()
    {
        $id = $this->request->id;
        $messages = $this->model->getMessages($id);
        $this->response->json($messages);
    }
}