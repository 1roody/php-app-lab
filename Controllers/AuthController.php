<?php

class AuthController {
    public $is_auth = false;
    public $username;
    public $user_id;
    
    public function login($username, $password) {
        return "login screen";
    }

    public function register($username, $password) {
        return "register screen";
    }

    public function checkAuth() {
        return $this->is_auth;
    }
}