<?php

namespace app\controllers;

use app\models\repositories\ProductRepository;

class ProductController extends Controller
{
    protected $defaultAction = 'catalog';

    protected function actionCatalog()
    {
        $catalog = (new ProductRepository())->getAll();
        //        echo $this->render('product/catalog', ['catalog' => $catalog]);
        echo $this->render('product/catalog', ['catalog' => $catalog]);
    }

    protected function actionCard()
    {
        $id = $this->request->getParams()['id'];
        $product = (new ProductRepository())->getOne($id);
        echo $this->render('product/card', ['product' => $product]);
    }
}
