<?php


namespace app\models;

use app\core\AbstractModel;

class UserModel extends AbstractModel
{
    protected $table = 'users';

    public function getByLogin(string $login){
        $query = "SELECT * FROM {$this->table} WHERE login like '{$login}' LIMIT 1;";
        $res = $this->db->query($query);
        if(!$res){
            throw new \mysqli_sql_exception($this->db->error);
        }
        return $res->fetch_assoc();
    }


}