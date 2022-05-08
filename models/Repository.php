<?php

namespace app\models;

use app\engine\Db;
use app\interfaces\IRepository;

abstract class Repository implements IRepository
{
    abstract protected function getTableName();
    abstract protected function getEntityClass();

    public function insert(Model $entity)
    {
        $params = [];
        foreach ($entity->props as $key => $value) {
            $params[$key] = $entity->$key;
        }

        $tableName = $this->getTableName();

        $sql = "INSERT INTO `{$tableName}` (`";
        $sql .= implode('`, `', array_keys($params));
        $sql .= '`) VALUES (:';
        $sql .= implode(', :', array_keys($params));
        $sql .= ');';

        Db::getInstance()->execute($sql, $params);
        $entity->id = Db::getInstance()->lastInsertId();
        return true;
    }

    public function update(Model $entity)
    {
        $params = [];
        foreach ($entity->props as $key => $value) {
            if (!$value) {
                continue;
            }
            $params[$key] = '`' . $key . '`="' . $entity->$key . '"';
        }

        if (count($params) == 0) {
            return false;
        }

        $tableName = $this->getTableName();

        $params_str = implode(', ', $params);
        $sql = "UPDATE `{$tableName}` SET {$params_str} WHERE `id`=:id;";
        Db::getInstance()->execute($sql, ['id' => $entity->id]);
        return true;
    }

    public function delete(Model $entity)
    {
        $id = $entity->id;
        $tableName = $this->getTableName();
        $sql = "DELETE FROM `{$tableName}` WHERE `id` = :id";
        return Db::getInstance()->execute($sql, ['id' => $id]);
    }

    public function save(Model $entity)
    {
        if (is_null($entity->id)) {
            $this->insert($entity);
        } else {
            $this->update($entity);
        }
    }

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM `{$tableName}` WHERE `id` = :id";
        $item = Db::getInstance()->queryOneObject(
            $sql,
            ['id' => $id],
            $this->getEntityClass()
        );
        if (!$item) {
            return null;
        }
        return $item;
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return Db::getInstance()->queryAll($sql, [], $this->getEntityClass());
    }

    public function getWhere($name, $value)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM `{$tableName}` WHERE `{$name}` = :value";
        $item = Db::getInstance()->queryOneObject(
            $sql,
            ['value' => $value],
            $this->getEntityClass()
        );
        if (!$item) {
            return null;
        }
        return $item;
    }

    public function getAllWhere($name, $value)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM `{$tableName}` WHERE `{$name}` = :value";
        $items = Db::getInstance()->queryAll(
            $sql,
            ['value' => $value],
            $this->getEntityClass()
        );
        return $items;
    }
}
