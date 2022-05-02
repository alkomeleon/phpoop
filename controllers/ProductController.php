<?php


namespace app\controllers;

use app\models\Product;

class ProductController extends Controller
{
    protected $defaultAction = 'catalog';

    protected function actionCatalog()
    {
        $catalog = Product::getAll();
//        echo $this->render('product/catalog', ['catalog' => $catalog]);
        echo $this->render('product/catalog', ['catalog' => $catalog]);
    }

    protected function actionCard()
    {
        $id = $_GET['id'];
        $product = Product::getOne($id);
        echo $this->render('product/card', ['product' => $product]);
    }

}