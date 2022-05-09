<?php

namespace app\engine;

use app\models\repositories\{
    CartItemRepository,
    OrderItemRepository,
    OrderRepository,
    ProductRepository,
    SessionRepository,
    UserRepository
};
use app\models\Cart;
use app\engine\Session;
use app\traits\TSingletone;

/**
 * Class App
 * @property CartItemRepository $cartItemRepository
 * @property OrderItemRepository $orderItemRepository
 * @property OrderRepository $orderRepository
 * @property ProductRepository $productRepository
 * @property SessionRepository $sessionRepository
 * @property UserRepository $userRepository
 * @property Cart $cart
 * @property Db $db
 * @property Session $session
 * @property Request $request
 */
class App
{
    use TSingletone;

    public $config;
    private $components;
    private $controller;
    private $action;
    protected $twig;

    public function run($config)
    {
        $this->config = $config;
        $this->components = new Storage();
        $loader = new \Twig\Loader\FilesystemLoader(
            $this->config['ROOT'] . $this->config['DS'] . 'templates'
        );
        $this->twig = new \Twig\Environment($loader, ['debug' => true]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->runController();
    }

    protected function runController()
    {
        $this->controller = $this->request->getControllerName() ?: 'product';
        $this->action = $this->request->getActionName();
        $controllerClass =
            $this->config['CONTROLLER_NAMESPACE'] .
            ucfirst($this->controller) .
            'Controller';
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($this->twig);
            $controller->runAction($this->action);
        } else {
            die('Нет такого контроллера');
        }
    }

    public function createComponent($name)
    {
        if (isset($this->config['components'][$name])) {
            $params = $this->config['components'][$name];
            $class = $params['class'];
            if (class_exists($class)) {
                unset($params['class']);
                $reflection = new \ReflectionClass($class);
                return $reflection->newInstanceArgs($params);
            } else {
                die('Нет класса компонента');
            }
        } else {
            die('Нет такого компонента');
        }
    }

    public function createComponentWithParams($name, $params)
    {
        if (isset($this->config['components'][$name])) {
            $class = $this->config['components']['class'];
            if (class_exists($class)) {
                $reflection = new \ReflectionClass($class);
                return $reflection->newInstanceArgs($params);
            } else {
                die('Нет класса компонента');
            }
        } else {
            die('Нет такого компонента');
        }
    }

    /**
     * @return static
     */
    public static function call()
    {
        return static::getInstance();
    }

    public function __get($name)
    {
        if ($name == 'config') {
            return $this->config;
        }
        return $this->components->get($name);
    }

    public function get($name, $params)
    {
        return $this->components->get($name);
    }
}
