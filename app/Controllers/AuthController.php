<?php

class AuthController {
    public $is_auth = false;
    public $username;
    public $password;
    public $user_id;
    
    public function login($username, $password) {
       $userModel = new User();
       $user = $userModel->getUserByUsername($username);
       
       if($user) {
        if($user['password'] == $password) {
            $_SESSION['is_auth'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            
            return true;
        }
       } else {
        return false;
       }
    }

    public function register($username, $password) {
        $userModel = new User();
        $result = $userModel->register($username, $password);
        return $result;
    }

    public function checkAuth() {
        return $_SESSION['is_auth'];
    }
}