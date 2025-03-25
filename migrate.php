<?php

use app\core\AbstractModel;

chdir('public');
include_once 'app/bootstrap.php';

class Migrate extends AbstractModel {

    public function __construct() {
        parent::__construct();

        $query = "CREATE TABLE users (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            login VARCHAR(255) UNIQUE,
            password VARCHAR(255),
            secret_answer VARCHAR(255)
        );";
        if($this->db->query($query)){
            echo "users table created\n";
        }else{
            echo 'Some problems users table creating ' . $this->db->error;
        }

        $query = "CREATE TABLE chats (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            user_first_id INT UNSIGNED NOT NULL,
            user_second_id INT UNSIGNED NOT NULL,
            FOREIGN KEY (user_first_id) REFERENCES users(id),
            FOREIGN KEY (user_second_id) REFERENCES users(id)
        );";
        if($this->db->query($query)){
            echo "chats table created\n";
        }else{
            echo 'Some problems chats table creating ' . $this->db->error;
        }

        $query = "CREATE TABLE messages (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            chat_id INT UNSIGNED NOT NULL,
            user_id INT UNSIGNED NOT NULL,
            message TEXT,
            created_at TIMESTAMP,
            FOREIGN KEY (chat_id) REFERENCES chats(id),
            FOREIGN KEY (user_id) REFERENCES users(id)
        );";
        if($this->db->query($query)){
            echo "messages table created\n";
        }else{
            echo 'Some problems messages table creating ' . $this->db->error;
        }

        $this->createDataTest();
    }
    private function createDataTest() {
        $query = "INSERT INTO users (name, login, password, secret_answer) VALUES
            ('Перший', 'one', 'pass1', 'answer1'),
            ('Другий', 'two', 'pass2', 'answer2'),
            ('Третій', 'three', 'pass3', 'answer3'),
            ('Четвертий', 'four', 'pass3', 'answer4');";
        if($this->db->query($query)){
            echo "Test users created\n";
        }else{
            echo 'Some problems with test users creating ' . $this->db->error;
        }

        $query = "INSERT INTO chats (name, user_first_id, user_second_id) VALUES
            ('Перший & Другий', 1, 2),
            ('Третій & Четвертий', 3, 4),
            ('Перший & Четвертий', 1, 4),
            ('Другий & Третій', 2, 3);";
        if($this->db->query($query)){
            echo "Test chats created\n";
        }else{
            echo 'Some problems with test chats creating ' . $this->db->error;
        }

        $query = "INSERT INTO messages (chat_id, user_id, message) VALUES
            (1, 1, 'Перший > Другому'),
            (1, 2, 'Другий > Першому.'),
            (2, 3, 'Третій > Четвертому'),
            (2, 4, 'Четвертий > Третьому'),
            (3, 1, 'Перший > Четвертому'),
            (3, 4, 'Четвертому > Першому'),
            (4, 2, 'Другий > Третьому'),
            (4, 3, 'Третій > Другому');";
        if($this->db->query($query)){
            echo "Test messages created\n";
        }else{
            echo 'Some problems with test messages creating ' . $this->db->error;
        }
    }
}

new Migrate();