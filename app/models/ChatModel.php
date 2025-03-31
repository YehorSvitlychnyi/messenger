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
    public function getChats(string $userId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_first_id = {$userId} OR user_second_id = {$userId};";
        $res = $this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function getMessages(string $chatId)
    {
        return $this->messageModel->getMessages($chatId);
    }
    public  function  addChat($userIdFirst, $userIdSecond)
    {
        $sql = "INSERT INTO {$this->table} (name, user_first_id, user_second_id) VALUES (CONCAT((SELECT name from users WHERE users.id = $userIdFirst)" . ",' & '," . "(SELECT name from users WHERE users.id = $userIdSecond)), $userIdFirst, $userIdSecond);";
        $res = $this->db->query($sql);
    }
}