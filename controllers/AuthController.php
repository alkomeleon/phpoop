<?php

namespace app\controllers;

use app\engine\App;
use app\models\User;
use app\engine\Session;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $params = App::call()->request->getParams();
        $login = $params['login'];
        $pass = $params['pass'];
        $remember = $params['remember'] == 'on';
        $session = App::call()->session;
        if ($session->auth($login, $pass, $remember)) {
            header('Location: /');
            die();
        } else {
            die('не верный логин или пароль');
        }
    }

    public function actionLogout()
    {
        $session = App::call()->session;
        $session->destroy();
        header('Location: /');
        die();
    }
}
