<?php

namespace app\models;


class User extends Model
{
    public $id;
    public $login;
    public $pass;


    public function __construct($login = null, $pass = null)
    {
        $this->login = $login;
        $this->pass = $pass;
    }


    protected function getTableName()
    {
        return 'users';
    }
}