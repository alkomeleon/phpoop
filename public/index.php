<?php

use app\engine\Autoload;
use app\models\{Product, User, Orders};
use app\engine\Db;

//TODO добавьте абсолютные пути
include "../engine/Autoload.php";
include "../config/config.php";

spl_autoload_register([new Autoload(), 'loadClass']);

$product = new Product();
$product->getOne(9);
var_dump($product);
//$product = new Product("Пицца","Описание", 125);
//$product->insert();
//echo "inserted product id: " . $product->id;
//$product->delete();
//
//$user = new User("User", 125);
//$user->insert();
//
//$order = new Orders(6, 500);
//$order->insert();

//$product = new Product();

//$product = $product->getOne(2);
//$product->delete();
