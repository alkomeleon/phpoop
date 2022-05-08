<?php
namespace app\models\entities;
use app\models\Model;

class Session extends Model
{
    protected $id;
    protected $key;
    protected $user_id;
    protected $expires;

    protected $props = [
        'key' => false,
        'user_id' => false,
        'expires' => false,
    ];

    public function __construct($key = null, $user_id = null, $expires = null)
    {
        $this->key = $key;
        $this->user_id = $user_id;
        $this->expires = $expires;
    }
}
