<?php
namespace app\models\entities;

use app\models\Model;
use app\models\repositories\ProductRepository;

class OrderItem extends Model
{
    protected $id;
    protected $order_id;
    protected $product_id;
    protected $count;
    protected $price;

    protected $props = [
        'order_id' => false,
        'product_id' => false,
        'count' => false,
        'price' => false,
    ];

    public function __construct(
        $order_id = null,
        $product_id = null,
        $count = null,
        $price = null
    ) {
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->count = $count;
        $this->price = $price;
    }

    public function getProduct()
    {
        $product = (new ProductRepository())->getOne($this->product_id);
        return $product;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getPrice()
    {
        return $this->price;
    }
}
