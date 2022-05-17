<?php
namespace app\models;
use app\models\entities\CartItem;
use app\engine\App;

class Cart
{
    protected $session_id;
    protected $items = [];

    public function __construct($session_id = null)
    {
        $this->session_id = $session_id;
        if (is_null($session_id)) {
            $this->session_id = App::call()->session->getId();
        }
        $this->items = App::call()->cartItemRepository->getAllWhere(
            'session_id',
            $this->session_id
        );
    }

    public function add($product_id)
    {
        if ($product_id == '') {
            return false;
        }
        $product_in_cart = false;
        foreach ($this->items as $item) {
            if ($item->product_id == $product_id) {
                $item->addOne();
                $product_in_cart = true;
                break;
            }
        }
        if (!$product_in_cart) {
            $product = App::call()->productRepository->getOne($product_id);
            if (!$product) {
                return false;
            }
            $item = new CartItem($this->session_id, $product_id, 1);
            App::call()->cartItemRepository->save($item);
            array_push($this->items, $item);
        }
        return true;
    }

    public function removeOne($product_id)
    {
        if ($product_id == '') {
            return false;
        }
        foreach ($this->items as $key => $item) {
            if ($item->product_id == $product_id) {
                if ($item->removeOne() == 0) {
                    unset($this->items[$key]);
                }
                return true;
            }
        }
        return false;
    }

    public function removeAll($product_id)
    {
        if ($product_id == '') {
            return false;
        }
        foreach ($this->items as $key => $item) {
            if ($item->product_id == $product_id) {
                App::call()->cartItemRepository->delete($item);
                unset($this->items[$key]);
                return true;
            }
        }
        return false;
    }

    public function count()
    {
        $count = 0;
        foreach ($this->items as $item) {
            $count += $item->product_count;
        }
        return $count;
    }

    public function itemCount($id)
    {
        foreach ($this->items as $item) {
            if ($item->product_id == $id) {
                return $item->product_count;
            }
        }
        return 0;
    }

    public function itemPrice($id)
    {
        foreach ($this->items as $item) {
            if ($item->product_id == $id) {
                return $item->getTotalPrice();
            }
        }
        return 0;
    }

    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotalPrice();
        }
        return $total;
    }

    public function clear()
    {
        foreach ($this->items as $item) {
            App::call()->cartItemRepository->delete($item);
        }
        $this->items = [];
        return true;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function __isset($name)
    {
        return isset($this->name);
    }

    public function __get($name)
    {
        return $this->$name;
    }
}
