<?php

namespace app\controllers;

use app\engine\App;

class ProductController extends Controller
{
    protected $defaultAction = 'catalog';

    protected function actionCatalog()
    {
        $catalog = App::call()->productRepository->getAll();
        echo $this->render('product/catalog', ['catalog' => $catalog]);
    }

    protected function actionCard()
    {
        $id = App::call()->request->getParams()['id'];
        $product = App::call()->productRepository->getOne($id);
        echo $this->render('product/card', ['product' => $product]);
    }
}
