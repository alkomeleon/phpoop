<?php

namespace app\controllers;

use app\models\repositories\OrderRepository;
use app\models\entities\Order;
use app\models\Cart;
use app\engine\Session;

class OrderController extends Controller
{
    protected $defaultAction = 'list';

    protected function actionList()
    {
        $session = new Session();
        $orders = [];
        if ($session->isAuthenticated()) {
            $orders = (new OrderRepository())->getAllWhere(
                'user_id',
                $session->getUser()->id
            );
        }
        echo $this->render('order/list', ['orders' => $orders]);
    }

    protected function actionCheckout()
    {
        $session = new Session();
        if (!$session->isAuthenticated()) {
            header('Location: /?c=cart');
            die();
        }
        $name = $this->request->getParams()['name'];
        $phone = $this->request->getParams()['phone'];
        $order = new Order($session->getUser()->id, $name, $phone);
        (new OrderRepository())->save($order);
        if (!$order->fill($session->getId())) {
            header('Location: /?c=cart');
            die();
        }
        (new Cart($session->getId()))->clear();
        $order->checkout();
        echo $this->render('order/success', ['order' => $order]);
    }
}
