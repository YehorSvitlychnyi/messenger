<?php


namespace app\models;


use app\core\AbstractModel;
use app\core\Session;

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
    public function changePassword(string $login, string $password){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE {$this->table} SET {$this->table}.password = '{$password}' WHERE {$this->table}.login LIKE '{$login}';";
        return $this->db->query($query);
    }
    public function getId()
    {
        $userData = $this->getByLogin(Session::getItem('login'));
        $userId = $userData['id'];
        return $userId;
    }

}