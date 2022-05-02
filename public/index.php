<?php

use app\engine\Autoload;
use app\models\{Product, User, Orders};
use app\engine\Db;

//TODO добавьте абсолютные пути
include "../engine/Autoload.php";
include "../config/config.php";

spl_autoload_register([new Autoload(), 'loadClass']);

require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(ROOT . DS .'templates');
$twig = new \Twig\Environment($loader,
    ['debug' => true]
);
$twig->addExtension(new \Twig\Extension\DebugExtension());


$controllerName = $_GET['c'] ?: 'product';
$actionName = $_GET['a'];

$controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClass)){
    $controller = new $controllerClass($twig);
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
