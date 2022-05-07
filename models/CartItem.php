<?php
namespace app\models;
use app\models\Product;

class CartItem extends DBModel
{
    protected $id;
    protected $session_id;
    protected $product_id;
    protected $product_count;

    protected $props = [
        'session_id' => false,
        'product_id' => false,
        'product_count' => false,
    ];

    public function __construct(
        $session_id = null,
        $product_id = null,
        $product_count = 1
    ) {
        $this->session_id = $session_id;
        $this->product_id = $product_id;
        $this->product_count = $product_count;
    }

    public function getProduct()
    {
        if ($this->product_id == null) {
            return null;
        }
        return Product::getOne($this->product_id);
    }

    public function getPrice()
    {
        $product = $this->getProduct();
        if ($product == null) {
            return null;
        }
        return $this->getProduct()->price;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getCount()
    {
        return $this->product_count;
    }

    public function getTotalPrice()
    {
        $price = $this->getPrice();
        if ($price == null) {
            return null;
        }
        return $price * $this->product_count;
    }

    public function addOne()
    {
        $this->product_count += 1;
        $this->props['product_count'] = true;
        $this->update();
        return true;
    }

    public function removeOne()
    {
        if ($this->product_count > 1) {
            $this->product_count -= 1;
            $this->props['product_count'] = true;
            $this->update();
            return $this->product_count;
        } else {
            $this->delete();
            return 0;
        }
    }

    protected static function getTableName()
    {
        return 'cart';
    }
}
