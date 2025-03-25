<?php

namespace app\core;

abstract class AbstractModel
{
    protected $db;

    protected $table;

    public function __construct()
    {
        $this->db = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function all(){
        $query = "SELECT * FROM {$this->table}";
        $res = $this->db->query($query);
        if(!$res){
            throw new \mysqli_sql_exception($this->db->error);
        }
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function add(array $data){
        $properties = [];
        $values = [];
        foreach ($data as $prop => $val){
            $properties[] = $prop;
            $values[] = "'$val'";
        }
        $query = "INSERT INTO {$this->table} (" . implode(',', $properties) . ") VALUES (" . implode(',', $values) . ");";
        return $this->db->query($query);
    }

    public function delete(int $id){
        $query = "DELETE FROM {$this->table} WHERE id = {$id}";
        return $this->db->query($query);
    }
}