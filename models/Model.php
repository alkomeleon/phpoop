<?php

namespace app\models;

use app\interfaces\IModel;

abstract class Model implements IModel
{
    protected $props = [];

    public function __set($name, $value)
    {
        if(array_key_exists($name, $this->props) and $this->$name !== $value){
            $this->props[$name] = true;
        }
        $this->$name = $value;
    }

    public function __isset($name)
    {
        return isset($this->name);
    }

    public function __get($name)
    {
        return $this->$name;
    }

}