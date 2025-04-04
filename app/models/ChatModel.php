<?php

namespace app\models;

use app\core\AbstractModel;
use app\core\Session;

class ChatModel extends AbstractModel
{
    protected $table = 'chats';
    protected MessagesModel $messageModel;

    public function __construct()
    {
        parent::__construct();
        $this->messageModel = new MessagesModel();
    }

    /**
     * @param string $userId
     *
     * @return array
     */
    public function getChats(string $userId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_first_id = {$userId} OR user_second_id = {$userId};";
        $res = $this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @param string $chatId
     *
     * @return array
     */
    public function getMessages(string $chatId): array
    {
        return $this->messageModel->getMessages($chatId);
    }

    /**
     * @param $userIdFirst
     * @param $userIdSecond
     *
     * @return void
     */
    public function addChat($userIdFirst, $userIdSecond): void
    {
        $sql = "INSERT INTO {$this->table} (name, user_first_id, user_second_id) VALUES (CONCAT((SELECT name from users WHERE users.id = $userIdFirst)" . ",' & '," . "(SELECT name from users WHERE users.id = $userIdSecond)), $userIdFirst, $userIdSecond);";
        $res = $this->db->query($sql);
    }
}