<?php

namespace app\models\repositories;

use app\models\Repository;
use app\models\entities\Session;

class SessionRepository extends Repository
{
    protected function getEntityClass()
    {
        return Session::class;
    }

    protected function getTableName()
    {
        return 'sessions';
    }
}
