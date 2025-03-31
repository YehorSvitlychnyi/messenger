<?php


namespace app\controllers;


use app\core\Request;
use app\core\Response;
use app\core\Route;
use app\core\Session;
use app\models\ChatModel;
use app\models\MessagesModel;
use app\models\UserModel;

class ApiController
{
    public $response;
    public $model;
    public $userModel;

    public $messageModel;
    public $request;
    public $acceptedUsers;

    public $user;

    public function __construct()
    {
        $this->response = new Response();
        $this->model = new ChatModel();
        $this->request = new Request();
        $this->userModel = new UserModel();
        $this->messageModel = new MessagesModel();
        $this->user = $this->userModel->getUser();
    }

    public function getChats()
    {
        $userId = $this->user['id'];
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
        $userId = $this->user['id'];
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
    public function addMessage(){
        $chatId = $this->request->chatId;
        $message = $this->request->message;
        $userId = $this->user['id'];
        $data = ['message' => $message, 'chat_id' => $chatId, 'user_id' => $userId];
        if($this->messageModel->add($data)){
            $this->response->json(['data'=>date('Y-m-d H:i:s')]);
        }else{
            $this->response->json(['data'=>'message not created']);
        }
    }
    public function logout(){
        Session::deleteItem('login');
    }
}
