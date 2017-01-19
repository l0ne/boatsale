<?php

class User extends ApiEngine {

    public function _GET_user_logout() {
        @session_start();
        unset($_SESSION['user']);
    }

    public function _GET_user() {
        $user = json_decode($_SESSION['user']);

        $userData = $this->data->getUserById($user->id);

        self::returnJson($userData);
    }

    public function _GET_user_all() {
        $userData = $this->data->getUsers();

        self::returnJson($userData);
    }

    public function _POST_user_login($data) {

        if (!isset($data->email) && !isset($data->password)) {
            self::returnError('Email and password require');
        }

        $user = $this->data->getUserByEmail($data->email);

        if (!$user) {
            self::returnError('Email not register');
        }

        if ($user->password !== $data->password) {
            self::returnError('Password invalid');
        }

        $userData = array('id' => $user->id, 'email' => $user->email);

        @session_start();
        $_SESSION['user'] = json_encode($userData);

        self::returnRedirect('Login success', '/');
    }
}