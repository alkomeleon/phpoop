<?php
namespace app\models;


class Orders extends DBModel
{
    protected $order_id;
    protected $user_id;
    protected $prod_id;
    protected $count;
    protected $price;

    protected $props = [
        'count' => false,
        'price' => false
    ];

    public function __construct($count = null, $price = null)
    {
        $this->count = $count;
        $this->price = $price;
    }


    protected static function getTableName()
    {
        return 'orders';
    }
}