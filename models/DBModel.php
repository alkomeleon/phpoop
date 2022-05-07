<?php

namespace app\models;

use app\engine\Db;

abstract class DBModel extends Model
{
    abstract protected static function getTableName();

    public function insert()
    {
        $params = [];
        foreach ($this->props as $key => $value) {
            $params[$key] = $this->$key;
        }

        $tableName = static::getTableName();

        $sql = "INSERT INTO `{$tableName}` (`";
        $sql .= implode('`, `', array_keys($params));
        $sql .= '`) VALUES (:';
        $sql .= implode(', :', array_keys($params));
        $sql .= ');';

        Db::getInstance()->execute($sql, $params);
        $this->id = Db::getInstance()->lastInsertId();
        return $this;
    }

    public function update()
    {
        $params = [];
        foreach ($this->props as $key => $value) {
            if (!$value) {
                continue;
            }
            $params[$key] = '`' . $key . '`="' . $this->$key . '"';
        }

        if (count($params) == 0) {
            return $this;
        }

        $tableName = static::getTableName();

        $params_str = implode(', ', $params);
        $sql = "UPDATE `{$tableName}` SET {$params_str} WHERE `id`=:id;";
        Db::getInstance()->execute($sql, ['id' => $this->id]);
        return $this;
    }

    public function delete()
    {
        $id = $this->id;
        $tableName = $this->getTableName();
        $sql = "DELETE FROM `{$tableName}` WHERE `id` = :id";
        return Db::getInstance()->execute($sql, ['id' => $id]);
    }

    public static function getOne($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM `{$tableName}` WHERE `id` = :id";
        $item = Db::getInstance()->queryOneObject(
            $sql,
            ['id' => $id],
            static::class
        );
        if (!$item) {
            return null;
        }
        return $item;
    }

    public static function getAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return Db::getInstance()->queryAll($sql, [], static::class);
    }

    public static function getWhere($name, $value)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM `{$tableName}` WHERE `{$name}` = :value";
        $item = Db::getInstance()->queryOneObject(
            $sql,
            ['value' => $value],
            static::class
        );
        if (!$item) {
            return null;
        }
        return $item;
    }

    public static function getAllWhere($name, $value)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM `{$tableName}` WHERE `{$name}` = :value";
        $items = Db::getInstance()->queryAll(
            $sql,
            ['value' => $value],
            static::class
        );
        return $items;
    }
}
