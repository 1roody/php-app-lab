<?php

class AuthController {
    public $is_auth = false;
    public $username;
    public $user_id;
    
    public function login($username, $password) {
        if($username == "admin" && $password = '1234') {
            return true;
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