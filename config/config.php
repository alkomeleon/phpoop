<?php

use app\engine\{Db, Request, Session};
use app\models\repositories\{
    CartItemRepository,
    OrderItemRepository,
    OrderRepository,
    ProductRepository,
    SessionRepository,
    UserRepository
};
use app\models\Cart;

return [
    'ROOT' => dirname(__DIR__),
    'DS' => DIRECTORY_SEPARATOR,
    'CONTROLLER_NAMESPACE' => 'app\\controllers\\',
    'VIEWS_DIR' => '../views/',
    'COOKIE_NAME' => 'session_cookie',
    'components' => [
        'db' => [
            'class' => Db::class,
            'driver' => 'mysql',
            'host' => 'localhost',
            'login' => 'root',
            'password' => 'root',
            'database' => 'shop',
            'charset' => 'utf8',
        ],
        'request' => [
            'class' => Request::class,
        ],
        'session' => [
            'class' => Session::class,
        ],
        'cartItemRepository' => [
            'class' => CartItemRepository::class,
        ],
        'orderItemRepository' => [
            'class' => OrderItemRepository::class,
        ],
        'orderRepository' => [
            'class' => OrderRepository::class,
        ],
        'productRepository' => [
            'class' => ProductRepository::class,
        ],
        'sessionRepository' => [
            'class' => SessionRepository::class,
        ],
        'userRepository' => [
            'class' => UserRepository::class,
        ],
        'cart' => [
            'class' => Cart::class,
        ],
    ],
];
