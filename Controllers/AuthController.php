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
            $this->is_auth = true;
            $this->username = $user['username'];
            $this->user_id = $user['id'];
            
            return true;
        }
       } else {
        return false;
       }
    }

    public function register($username, $password) {
        return "register screen";
    }

    public function checkAuth() {
        return $this->is_auth;
    }
}