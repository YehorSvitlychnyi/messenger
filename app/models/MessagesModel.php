<?php


namespace app\models;


use app\core\AbstractModel;

class MessagesModel extends AbstractModel
{
    protected $table = 'messages';

    public function getMessages($id)
    {
        $sql = "SELECT * FROM $this->table WHERE chat_id = $id;";
        $res = $this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}