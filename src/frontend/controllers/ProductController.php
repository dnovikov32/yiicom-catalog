<?php

namespace yiicom\catalog\frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yiicom\common\base\Controller;
use yiicom\content\frontend\traits\SitePageTrait;
use yiicom\catalog\common\models\Product;

class ProductController extends Controller
{
    use SitePageTrait;

	public function actionView($id)
	{
	    /** @var Product $product */
        $product = $this->loadModel(Product::class, $id);

		return $this->render('view', [
			'product' => $product,
		]);
	}

}
