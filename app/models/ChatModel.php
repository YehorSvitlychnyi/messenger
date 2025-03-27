<?php

namespace app\models;

use app\core\AbstractModel;
use app\core\Session;

class ChatModel extends AbstractModel
{
    protected $table = 'chats';
    protected $messageModel;

    public function __construct()
    {
        parent::__construct();
        $this->messageModel = new MessagesModel();
    }

    private function getId()
    {
        $user = new UserModel();
        $userData = $user->getByLogin(Session::getItem('login'));
        $userId = $userData['id'];
        return $userId;
    }
    public function getChats()
    {
        $id = $this->getId();
        $sql = "SELECT * FROM {$this->table} WHERE user_first_id = {$id} OR user_second_id = {$id};";
        $res = $this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function getMessages(string $id)
    {
        return $this->messageModel->getMessages($id);
    }
}