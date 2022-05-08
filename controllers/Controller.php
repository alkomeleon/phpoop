<?php

namespace app\controllers;
use app\models\{User, Cart};
use app\engine\{Request, Session};

abstract class Controller
{
    protected $action;
    protected $defaultAction = 'index';
    protected $twig;
    protected $request;

    function __construct($twig)
    {
        $this->twig = $twig;
        $this->request = new Request();
    }

    protected function actionIndex()
    {
        echo $this->render('index');
    }

    public function runAction($action)
    {
        $this->action = $action ?: $this->defaultAction;
        $method = 'action' . ucfirst($this->action);
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            die('нет такого экшена');
        }
    }

    public function render($template, $params = [])
    {
        if (substr($template, -5) != '.twig') {
            $template = $template . '.twig';
        }
        $session = new Session();
        $params['isAuthenticated'] = $session->isAuthenticated();
        $params['username'] = $session->getLogin();
        $cart = new Cart($session->getId());
        $params['cartCount'] = $cart->count();
        return $this->twig->render($template, $params);
    }
}
