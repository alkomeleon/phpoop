<?php
namespace app\models\entities;

use app\models\Model;

class Product extends Model
{
    protected $id;
    protected $name = null;
    protected $description = null;
    protected $price = null;

    protected $props = [
        'name' => false,
        'description' => false,
        'price' => false,
    ];

    public function __construct(
        $name = null,
        $description = null,
        $price = null
    ) {
        if (is_null($name) and is_null($description) and is_null($price)) {
            return;
        }
        if (!is_string($name)) {
            throw new \Exception('Название должно быть строкой');
        }
        if (strlen(str_replace(' ', '', $name)) == 0) {
            throw new \Exception('Название не должно быть пустым');
        }

        if (!is_string($description)) {
            throw new \Exception('Описание должно быть строкой');
        }
        if (strlen(str_replace(' ', '', $description)) == 0) {
            throw new \Exception('Описание не должно быть пустым');
        }

        if (!is_int($price) and !is_float($price)) {
            throw new \Exception('Цена должна быть числом');
        }
        if ($price <= 0) {
            throw new \Exception('Цена не может быть меньше или равна 0');
        }
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }
}
