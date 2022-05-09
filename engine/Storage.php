<?php

namespace app\engine;
use app\engine\App;

class Storage
{
    protected $items = [];

    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }

    public function get($key)
    {
        if (!isset($this->items[$key])) {
            $this->items[$key] = App::call()->createComponent($key);
        }
        return $this->items[$key];
    }

    public function getWithParams($key, $params)
    {
        if (!isset($this->items[$key])) {
            $this->items[$key] = App::call()->createComponentWithParams(
                $key,
                $params
            );
        }
        return $this->items[$key];
    }
}
