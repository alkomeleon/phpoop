<?php

namespace app\controllers;

use app\engine\App;
use app\models\entities\Order;

class OrderController extends Controller
{
    protected $defaultAction = 'list';

    protected function actionList()
    {
        $session = App::call()->session;
        $orders = [];
        if ($session->isAuthenticated()) {
            $orders = App::call()->orderRepository->getAllWhere(
                'user_id',
                $session->getUser()->id
            );
        }
        echo $this->render('order/list', ['orders' => $orders]);
    }

    protected function actionCheckout()
    {
        $session = App::call()->session;
        if (!$session->isAuthenticated()) {
            header('Location: /?c=cart');
            die();
        }
        $name = App::call()->request->getParams()['name'];
        $phone = App::call()->request->getParams()['phone'];
        $order = new Order($session->getUser()->id, $name, $phone);
        App::call()->orderRepository->save($order);
        if (!$order->fill($session->getId())) {
            header('Location: /?c=cart');
            die();
        }
        App::call()->cart->clear();
        $order->checkout();
        echo $this->render('order/success', ['order' => $order]);
    }
}
