<?php

namespace app\models\entities;
use app\engine\Session;
use app\models\Model;

class User extends Model
{
    protected $id;
    protected $login;
    protected $password;
    protected $role;

    protected $props = [
        'login' => false,
        'password' => false,
        'role' => false,
    ];

    public function __construct($login = null, $password = null, $role = null)
    {
        $this->login = $login;
        $this->password = $password;
        $this->role = $password;
    }
}
