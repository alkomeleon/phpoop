<?php


namespace app\controllers;


use app\models\Product;

class CartController extends Controller
{
    protected $defaultAction = 'cart';

    protected function actionCart()
    {
        echo $this->render('cart/cart', []);
    }

    protected function actionCheckout()
    {
        echo $this->render('cart/checkout', []);
    }

}