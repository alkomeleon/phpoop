<?php

use app\engine\Autoload;
use app\models\{Product, User, Orders};
use app\engine\{Db, Request};

//TODO добавьте абсолютные пути
//include '../engine/Autoload.php';
include '../config/config.php';

//spl_autoload_register([new Autoload(), 'loadClass']);

require_once '../vendor/autoload.php';

try {
    $loader = new \Twig\Loader\FilesystemLoader(ROOT . DS . 'templates');
    $twig = new \Twig\Environment($loader, ['debug' => true]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());

    $request = new Request();

    $controllerName = $request->getControllerName() ?: 'product';
    $actionName = $request->getActionName();

    $controllerClass =
        CONTROLLER_NAMESPACE . ucfirst($controllerName) . 'Controller';

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass($twig);
        $controller->runAction($actionName);
    } else {
        die('нет такого контроллера');
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}
