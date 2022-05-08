<?php

namespace app\models\repositories;

use app\models\Repository;
use app\models\entities\User;

class UserRepository extends Repository
{
    protected function getEntityClass()
    {
        return User::class;
    }

    protected function getTableName()
    {
        return 'users';
    }
}
