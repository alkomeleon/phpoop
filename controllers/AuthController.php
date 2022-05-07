<?php

namespace app\controllers;

use app\models\User;
use app\engine\Session;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $params = $this->request->getParams();
        $login = $params['login'];
        $pass = $params['pass'];
        $remember = $params['remember'] == 'on';
        $session = new Session();
        if ($session->auth($login, $pass, $remember)) {
            header('Location: /');
            die();
        } else {
            die('не верный логин или пароль');
        }
    }

    public function actionLogout()
    {
        $session = new Session();
        $session->destroy();
        header('Location: /');
        die();
    }
}
