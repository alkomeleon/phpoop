<?php

namespace app\models;

use app\engine\Db;
use app\interfaces\IModel;

abstract class Model implements IModel
{

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function insert()
    {
        $params = [];
        foreach ($this as $key => $value) {
            if($key=="id"){
                continue;
            }
            $params[$key]=$value;
        }

        $tableName = $this->getTableName();

        $sql = "INSERT INTO `{$tableName}` (`";
        $sql .= implode("`, `", array_keys($params));
        $sql .= "`) VALUES (:";
        $sql .= implode(", :", array_keys($params));
        $sql .= ");";


        Db::getInstance()->execute($sql, $params);
        $this->id = Db::getInstance()->lastInsertId();
        return $this;
    }

    public function delete() {
        $id = $this->id;
        $tableName = $this->getTableName();
        $sql = "DELETE FROM `{$tableName}` WHERE id = :id";
        return Db::getInstance()->execute($sql, ['id'=>$id]);
    }

    public function getOne($id) {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        $params =  Db::getInstance()->queryOne($sql, ['id' => $id]);
        foreach ($params as $key => $value){
            $this->$key = $value;
            if($key=='id'){
                $this->id = intval($value);
            }
        }
        return $this;
       // return Db::getInstance()->queryOneObject($sql, ['id' => $id], static::class);
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->getTableName()}";
        return Db::getInstance()->queryAll($sql);
    }

    protected abstract function getTableName();


}