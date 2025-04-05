<?php


namespace app\models;


use app\core\AbstractModel;
use app\core\Session;

class UserModel extends AbstractModel
{
    protected $table = 'users';

    /**
     * @param string $login
     * get user data by login from database
     * @return array|false|null
     */
    public function getByLogin(string $login): bool|array|null
    {
        $query = "SELECT * FROM {$this->table} WHERE login like '{$login}' LIMIT 1;";
        $res   = $this->db->query($query);
        if (!$res) {
            throw new \mysqli_sql_exception($this->db->error);
        }
        return $res->fetch_assoc();
    }

    /**
     * @param string $login
     * @param string $password
     * updating user password in database
     * @return bool|\mysqli_result
     */
    public function changePassword(string $login, string $password): \mysqli_result|bool
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query    = "UPDATE {$this->table} SET {$this->table}.password = '{$password}' WHERE {$this->table}.login LIKE '{$login}';";
        return $this->db->query($query);
    }

    /**
     * @return array|bool|null
     * get user data by login from session
     */
    public function getUser(): bool|array|null
    {
        $userData = $this->getByLogin(Session::getItem('login'));
        return $userData;
    }
}