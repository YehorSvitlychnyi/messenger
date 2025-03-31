<?php


namespace app\models;


use app\core\AbstractModel;

class MessagesModel extends AbstractModel
{
    protected $table = 'messages';

    public function getMessages($chatId)
    {
        $sql = "SELECT messages.message as message, messages.created_at as created_at, users.name, users.login from messages LEFT OUTER JOIN users on messages.user_id = users.id WHERE messages.chat_id = $chatId;";
        $res = $this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}