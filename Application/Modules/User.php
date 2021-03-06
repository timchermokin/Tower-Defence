<?php

class User {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($options = null) {
        if ($options && isset($options->login) && isset($options->password)) {
            $user = $this->db->getUser($options->login, $options->password);
            if ($user) {
                $token = md5($user->login . rand(0, 50000));
                $this->db->updateUserToken($user->id, $token);
                return $token;
            }
        }
        return false;
    }

    public function logout($options = null) {
        if ($options && isset($options->token)) {
            $user = $this->db->getUserByToken($options->token);
            if ($user) {
                return $this->db->updateUserToken($user->id, '');
            }
        }
        return false;
    }

    public function checkToken($options = null) {
        if ($options && isset($options->token)) {
            $user = $this->db->getUserByToken($options->token);
            if ($user) {
                return $user->id;
            }
        }
        return false;
    }
}