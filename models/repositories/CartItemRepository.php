<?php

namespace app\models\repositories;

use app\models\entities\CartItem;
use app\models\Repository;

class CartItemRepository extends Repository
{
    protected function getEntityClass()
    {
        return CartItem::class;
    }

    protected function getTableName()
    {
        return 'cart';
    }
}
