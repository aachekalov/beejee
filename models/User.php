<?php

namespace app\models;

class User
{
    private static $users = [
        [
            'user' => 'admin',
            'password' => '123',
        ],
    ];

    public $errors = [];

    public function loadData($data)
    {
        $this->user = $data['user'];
        $this->password = $data['password'];
    }

    public function validate()
    {
        if (empty($this->user)) {
            $this->errors['user'] = 'Имя пользователя не может быть пустым';
        }
        if (empty($this->password)) {
            $this->errors['password'] = 'Пароль не может быть пустым';
        }
        return count($this->errors) === 0;
    }

    /**
     * Login as admin.
     */
    public function login()
    {
        foreach (self::$users as $user) {
            if ($user['user'] == $this->user && $user['password'] == $this->password) {
                $_SESSION['admin'] = true;
                return true;
            }
        }
        $this->errors['password'] = 'Неверное имя пользователя или пароль';
        return false;
    }
}
