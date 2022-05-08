<?php

namespace app\models\repositories;

use app\models\entities\OrderItem;
use app\models\Repository;

class OrderItemRepository extends Repository
{
    protected function getEntityClass()
    {
        return OrderItem::class;
    }

    protected function getTableName()
    {
        return 'order_items';
    }
}
