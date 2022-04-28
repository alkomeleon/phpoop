<?php

use app\engine\Autoload;
use app\models\{Product, User, Orders};
use app\engine\Db;

//TODO добавьте абсолютные пути
include "../engine/Autoload.php";
include "../config/config.php";

spl_autoload_register([new Autoload(), 'loadClass']);



//
//$product = Product::getOne(12);
////$product->name = 'pizza';
////$product->price = 100;
//echo "<pre>";
////$product->update();
//var_dump($product);
//
//
//
//
//
//
//
//
//
//
//
//
//die();
$controllerName = $_GET['c'] ?: 'product';
$actionName = $_GET['a'];

$controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClass)){
    $controller = new $controllerClass();
    $controller->runAction($actionName);
} else {
    die("нет такого контроллера");
}





























//$product = new Product();
//$product->getOne(9);

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
