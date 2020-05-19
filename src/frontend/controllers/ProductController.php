<?php

namespace yiicom\catalog\frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yiicom\common\base\Controller;
use yiicom\content\frontend\traits\SitePageTrait;
use yiicom\catalog\common\models\Product;
use yiicom\catalog\common\lists\AttributeList;
use yiicom\content\common\relations\RelationFinder;

class ProductController extends Controller
{
    use SitePageTrait;

	public function actionView($id)
	{
	    /** @var Product $product */
        $product = $this->loadModel(Product::class, $id);

        $category = $product->category;

        $categoryParents = $category->parents()
            ->orderBy('level')
            ->all();

        $images = $product->files;

        $attributes = (new AttributeList())->get();

        $relations = (new RelationFinder($product))->find();
        
		return $this->render('view', [
			'product' => $product,
            'images' => $images,
            'category' => $category,
            'categoryParents' => $categoryParents,
            'attributes' => $attributes,
            'relations' => $relations,
		]);
	}

}
