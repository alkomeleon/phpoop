<?php

namespace app\controllers;

use app\engine\App;
use app\models\entities\Order;

class AdminController extends Controller
{
    protected $defaultAction = 'orders';

    protected function actionOrders()
    {
        $session = App::call()->session;
        if ($session->getUser()->role !== 'admin') {
            die('404');
        }
        $orders = [];
        if ($session->isAuthenticated()) {
            $orders = App::call()->orderRepository->getAll();
        }
        echo $this->render('admin/orders', ['orders' => $orders]);
    }

    protected function actionViewOrder()
    {
        $session = App::call()->session;
        if ($session->getUser()->role !== 'admin') {
            die('404');
        }
        $id = App::call()->request->getParams()['id'];
        $order = App::call()->orderRepository->getOne($id);
        echo $this->render('admin/view_order', ['order' => $order]);
    }
}
