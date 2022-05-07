<?php

namespace app\models;
use app\engine\Session;

class User extends DBModel
{
    protected $id;
    protected $login;
    protected $password;

    protected $props = [
        'login' => false,
        'password' => false,
    ];

    public function __construct($login = null, $password = null)
    {
        $this->login = $login;
        $this->password = $password;
    }

    protected static function getTableName()
    {
        return 'users';
    }
}
