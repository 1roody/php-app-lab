<?php

class User {
    public $id;
    public $username;
    public $password;
    public $connection;

    public function __construct() {
        $this->connection = new mysqli('mysql', 'vulnuser', 'senha@123', 'vulnapp');
    }

    public function getAll() {
        $sql = "SELECT * FROM users";
        $result = $this->connection->query($sql);
        $users = [];
        
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        
        return $users;
        
    }

    public function register($username, $password) {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        $result = $this->connection->query($sql);
        return $result;
    }

    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->connection->query($sql);
        $user = $result->fetch_assoc();
        
        return $user;
    }

    public function __destruct() {
        $this->connection->close();
    }
}