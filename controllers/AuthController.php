<?php


namespace app\controllers;

use app\models\User;

class AuthController extends Controller
{
    public function actionLogin() {
        $login = $_POST['login'];
        $pass = $_POST['pass'];
        if (User::Auth($login, $pass)) {
            header("Location: /");
            die();
        } else {
            die("не верный логин ли пароль");
        }
    }

    public function actionLogout() {
        session_regenerate_id();
        session_destroy();
        header("Location: /");
        die();
    }
}