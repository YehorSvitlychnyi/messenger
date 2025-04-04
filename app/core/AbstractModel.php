<?php


namespace app\core;


abstract class AbstractModel
{
    protected \mysqli $db;
    protected $table;

    public function __construct()
    {
        $this->db = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    /**
     * get all records from notes
     * @return array
     */
    public function all(): array
    {
        $query = "SELECT * FROM {$this->table}";
        $res   = $this->db->query($query);
        if (!$res) {
            throw new \mysqli_sql_exception($this->db->error);
        }
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * add new record to table
     * @param array $data
     *
     * @return bool|\mysqli_result
     */
    public function add(array $data): \mysqli_result|bool
    {
        $properties = [];
        $values     = [];
        foreach ($data as $prop => $val) {
            $properties[] = $prop;
            $values[]     = "'$val'";
        }
        $query = "INSERT INTO {$this->table} (" . implode(',', $properties) . ") VALUES (" . implode(',', $values) . ");";
        return $this->db->query($query);
    }
}