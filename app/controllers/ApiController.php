<?php


namespace app\controllers;


use app\core\Request;
use app\core\Response;
use app\core\Session;
use app\models\ChatModel;
use app\models\MessagesModel;
use app\models\UserModel;

class ApiController
{
    public Response $response;
    public ChatModel $model;
    public UserModel $userModel;
    public MessagesModel $messageModel;
    public Request $request;
    public array|null|false $user;
    public $acceptedUsers;

    public function __construct()
    {
        $this->response = new Response();
        $this->model = new ChatModel();
        $this->request = new Request();
        $this->userModel = new UserModel();
        $this->messageModel = new MessagesModel();
        $this->user = $this->userModel->getUser();
    }

    /**
     * Gets chats by userId(from session)
     * @return void
     */
    public function getChats(): void
    {
        $userId = $this->user['id'];
        $chats = $this->model->getChats($userId);
        $this->response->json($chats);
    }

    /**
     * Get messages by chatID(from request)
     * @return void
     */
    public function getMessages(): void
    {
        $chatId = $this->request->id;
        $messages = $this->model->getMessages($chatId);
        $this->response->json($messages);
    }

    /**
     * Get users from select except already used user for chatting
     * @return void
     */
    public function getUsers(): void
    {
        $data = $this->userModel->all();
        $userId = $this->user['id'];
        $chats = $this->model->getChats($userId);
        foreach ($data as $key => $user) {
            if ($user['id'] == $userId) {
                unset($data[$key]);
            }
            foreach ($chats as $chat) {
                if ($user['id'] == $chat['user_first_id'] || $user['id'] == $chat['user_second_id']) {
                    unset($data[$key]);
                }
            }
        }
        $data = array_values($data);
        $this->acceptedUsers = $data;
        $this->response->json($data);
    }

    /**
     * create new chat and add to DB by userID's getting from request
     * @return void
     */
    public function addChat(): void
    {
        $userIdFirst = $this->request->userIdFirst;
        $userIdSecond = $this->request->userIdSecond;
        $this->model->addChat($userIdFirst, $userIdSecond);
    }

    /**
     * Pushing current user on client
     * @return void
     */
    public function getUser(): void
    {
        $userData = $this->userModel->getUser();
        $user['name'] = $userData['name'];
        $user['login'] = $userData['login'];
        $user['id'] = $userData['id'];
        $this->response->json($user);
    }

    /**
     * Add message to DB from request
     * @return void
     */
    public function addMessage(): void
    {
        $chatId = $this->request->chatId;
        $message = $this->request->message;
        $userId = $this->user['id'];
        $data = ['message' => $message, 'chat_id' => $chatId, 'user_id' => $userId];
        if ($this->messageModel->add($data)) {
            $this->response->json(['data' => date('Y-m-d H:i:s')]);
        } else {
            $this->response->json(['data' => 'message not created']);
        }
    }

    /**
     * Unset user from Session
     * @return void
     */
    public function logout(): void
    {
        Session::deleteItem('login');
    }
}
