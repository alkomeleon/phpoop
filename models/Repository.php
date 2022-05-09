<?php

namespace app\models;

use app\engine\App;
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

        App::call()->db->execute($sql, $params);
        $entity->id = App::call()->db->lastInsertId();
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
        App::call()->db->execute($sql, ['id' => $entity->id]);
        return true;
    }

    public function delete(Model $entity)
    {
        $id = $entity->id;
        $tableName = $this->getTableName();
        $sql = "DELETE FROM `{$tableName}` WHERE `id` = :id";
        return App::call()->db->execute($sql, ['id' => $id]);
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
        $item = App::call()->db->queryOneObject(
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
        return App::call()->db->queryAll($sql, [], $this->getEntityClass());
    }

    public function getWhere($name, $value)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM `{$tableName}` WHERE `{$name}` = :value";
        $item = App::call()->db->queryOneObject(
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
        $items = App::call()->db->queryAll(
            $sql,
            ['value' => $value],
            $this->getEntityClass()
        );
        return $items;
    }
}
