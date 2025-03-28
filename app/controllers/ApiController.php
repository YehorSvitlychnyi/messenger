<?php


namespace app\controllers;


use app\core\Request;
use app\core\Response;
use app\models\ChatModel;
use app\models\UserModel;

class ApiController
{
    public $response;
    public $model;
    public $userModel;
    public $request;
    public $acceptedUsers;

    public function __construct()
    {
        $this->response = new Response();
        $this->model = new ChatModel();
        $this->request = new Request();
        $this->userModel = new UserModel();
    }

    public function getChats()
    {
        $userId = $this->userModel->getId();
        $chats = $this->model->getChats($userId);
        $this->response->json($chats);
    }
    public function getMessages()
    {
        $chatId = $this->request->id;
        $messages = $this->model->getMessages($chatId);
        $this->response->json($messages);
    }
    public function getUsers()
    {
        $data = $this->userModel->all();
        $userId = $this->userModel->getId();
        $chats = $this->model->getChats($userId);
        foreach($data as $key => $user){
            if($user['id'] == $userId){
                unset($data[$key]);
            }
            foreach($chats as $chat){
                if($user['id'] == $chat['user_first_id'] || $user['id'] == $chat['user_second_id']){
                    unset($data[$key]);
                }
            }
        }
        $data = array_values($data);
        $this->acceptedUsers = $data;
        $this->response->json($data);
    }

}