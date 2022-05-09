<?php

namespace app\controllers;
use app\engine\App;
use app\models\{User, Cart};
use app\engine\{Request, Session};

class Controller
{
    protected $action;
    protected $defaultAction = 'index';
    protected $twig;

    function __construct($twig)
    {
        $this->twig = $twig;
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
        $session = App::call()->session;
        $params['isAuthenticated'] = $session->isAuthenticated();
        $params['userRole'] = $session->getUser()->role;
        $params['username'] = $session->getLogin();
        $cart = App::call()->cart;
        $params['cartCount'] = $cart->count();
        return $this->twig->render($template, $params);
    }
}
