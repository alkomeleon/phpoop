<?php
namespace app\models;


class Orders extends Model
{
    public $order_id;
    public $user_id;
    public $prod_id;
    public $count;
    public $price;


    public function __construct($count = null, $price = null)
    {
        $this->count = $count;
        $this->price = $price;
    }


    protected function getTableName()
    {
        return 'orders';
    }
}