<?php

namespace app\controllers;

use app\models\{Product, Cart, CartItem};
use app\engine\{Session};

class CartController extends Controller
{
    protected $defaultAction = 'cart';

    protected function actionCart()
    {
        $session = new Session();
        $cart = new Cart($session->getId());
        echo $this->render('cart/cart', ['cart' => $cart]);
    }

    protected function actionAdd()
    {
        $session = new Session();
        $id = $this->request->getParams()['id'];
        $cart = new Cart($session->getId());
        $response = ['result' => 'error'];
        if ($cart->add($id)) {
            $response['result'] = 'ok';
        }
        $response['cart_count'] = $cart->count();
        echo json_encode($response);
    }

    protected function actionRemoveOne()
    {
        $session = new Session();
        $id = $this->request->getParams()['id'];
        $cart = new Cart($session->getId());
        $response = ['result' => 'error'];
        if ($cart->removeOne($id)) {
            $response['result'] = 'ok';
            $response['item_count'] = $cart->itemCount($id);
        }
        $response['cart_count'] = $cart->count();
        echo json_encode($response);
    }

    protected function actionRemoveAll()
    {
        $session = new Session();
        $id = $this->request->getParams()['id'];
        $cart = new Cart($session->getId());
        $response = ['result' => 'error'];
        if ($cart->removeAll($id)) {
            $response['result'] = 'ok';
        }
        $response['cart_count'] = $cart->count();
        echo json_encode($response);
    }

    protected function actionClear()
    {
        $session = new Session();
        $cart = new Cart($session->getId());
        $response = ['result' => 'error'];
        if ($cart->clear()) {
            $response['result'] = 'ok';
        }
        $response['cart_count'] = $cart->count();
        echo json_encode($response);
    }

    protected function actionCheckout()
    {
        echo $this->render('cart/checkout', []);
    }
}
