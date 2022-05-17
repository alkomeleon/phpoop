<?php
namespace app\models\entities;
use app\models\entities\Product;
use app\engine\App;
use app\models\Model;

class CartItem extends Model
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
        return App::call()->productRepository->getOne($this->product_id);
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
        App::call()->cartItemRepository->save($this);
        return true;
    }

    public function removeOne()
    {
        if ($this->product_count > 1) {
            $this->product_count -= 1;
            $this->props['product_count'] = true;
            App::call()->cartItemRepository->save($this);
            return $this->product_count;
        } else {
            App::call()->cartItemRepository->delete($this);
            return 0;
        }
    }
}
