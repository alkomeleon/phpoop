<?php
namespace app\models\entities;

use app\models\Model;
use app\models\entities\OrderItem;
use app\engine\App;

class Order extends Model
{
    protected $id;
    protected $user_id;
    protected $name;
    protected $phone;
    protected $date;
    protected $status;

    protected $props = [
        'user_id' => false,
        'name' => false,
        'phone' => false,
        'status' => false,
    ];

    public function __construct(
        $user_id = null,
        $name = null,
        $phone = null,
        $status = 0
    ) {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->phone = $phone;
        $this->status = $status;
    }

    public function fill($session_id)
    {
        if (is_null($this->id)) {
            return false;
        }
        $items = App::call()->cartItemRepository->getAllWhere(
            'session_id',
            $session_id
        );
        foreach ($items as $item) {
            $orderItem = new OrderItem(
                $this->id,
                $item->product_id,
                $item->product_count,
                $item->getPrice()
            );
            App::call()->orderItemRepository->save($orderItem);
        }
        return true;
    }

    public function checkout()
    {
        $this->status = 1;
        $this->props['status'] = true;
        App::call()->orderRepository->save($this);
        return $this->status;
    }

    public function getContents()
    {
        $items = App::call()->orderItemRepository->getAllWhere(
            'order_id',
            $this->id
        );
        return $items;
    }

    public function getCount()
    {
        $items = App::call()->orderItemRepository->getAllWhere(
            'order_id',
            $this->id
        );
        return count($items);
    }

    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->getContents() as $item) {
            $total += $item->price * $item->count;
        }
        return $total;
    }

    public function getStatusText()
    {
        switch ($this->status) {
            case 0:
                return 'Не сформирован';
            case 1:
                return 'Оформлен';
            case 2:
                return 'Доставлен';
            default:
                return 'Ошибка';
        }
    }
}
