<?php

use app\core\AbstractModel;

chdir('public');
include_once 'app/bootstrap.php';

class Migrate extends AbstractModel {

    public function __construct() {
        parent::__construct();

        $this->drop('messages');
        $this->drop('chats');
        $this->drop('users');
    }

    public function drop($table)
    {
        $query = "DROP TABLE $table";
        if($this->db->query($query)){
            echo "$table table dropped\n";
        }else{
            echo "Some problems when $table dropping " . $this->db->error;
        }
    }
}

new Migrate();
