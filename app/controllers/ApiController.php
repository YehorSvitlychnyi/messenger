<?php


namespace app\controllers;


use app\core\Request;
use app\core\Response;
use app\core\Route;
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
        $user = $this->userModel->getUser();
        $userId = $user['id'];
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
        $user = $this->userModel->getUser();
        $userId = $user['id'];
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
    public function addChat()
    {
        $userIdFirst = $this->request->userIdFirst;
        $userIdSecond = $this->request->userIdSecond;
        //todo validate accepted users
        $this->model->addChat($userIdFirst, $userIdSecond);
    }
    public function getUser()
    {
        $userData = $this->userModel->getUser();
        $user['name'] = $userData['name'];
        $user['login'] = $userData['login'];
        $user['id'] = $userData['id'];
        $this->response->json($user);
    }
}
