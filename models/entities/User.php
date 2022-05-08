<?php

namespace app\models\entities;
use app\engine\Session;
use app\models\Model;

class User extends Model
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
}
