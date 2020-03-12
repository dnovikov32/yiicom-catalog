<?php

namespace yiicom\catalog\frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yiicom\common\base\Controller;
use yiicom\content\common\models\Page;
use yiicom\content\frontend\traits\SitePageTrait;
use yiicom\catalog\common\models\Category;
use yiicom\catalog\common\models\Product;
use yiicom\catalog\common\lists\AttributeList;

class CategoryController extends Controller
{
    use SitePageTrait;

    /**
     * Catalog page
     * @param int $id Category ID
     * @return string
     */
	public function actionIndex($id)
	{
        $category = $this->loadModel(Category::class, $id);

		return $this->render('index', [
			'category' => $category,
		]);
	}

	public function actionView($id)
	{
	    /** @var Category $category */
        $category = $this->loadModel(Category::class, $id);

        $categoryParents = $category->parents()
            ->orderBy('level')
            ->all();

        $categoryChildren = $category->children()
            ->withUrl()
            ->orderBy('left')
            ->all();
        
        $categoryIds = array_merge([$category->id], ArrayHelper::getColumn($categoryChildren, 'id'));
        
        $products = Product::find()
            ->withUrl()
            ->withFiles()
            ->withAttributeValue()
            ->category($categoryIds)
            ->active()
            ->all();

        $attributes = (new AttributeList())->filter(['isShowInCard' => true])->get();

		return $this->render('view', [
			'category' => $category,
			'categoryChildren' => $categoryChildren,
			'categoryParents' => $categoryParents,
			'products' => $products,
			'attributes' => $attributes,
		]);
	}


	public function actionAjaxGetProducts()
	{
		$this->layout = false;

		$params = Yii::$app->request->post();

		if(!isset($params['data'])) {
			return false;
		}

		parse_str($params['data'], $params);

//		echo '<pre>'; print_r($params); echo '</pre>';

		$products = Product::getProducts($params);
//		echo '<pre>$products'; print_r($products); echo '</pre>';

		return $this->render('//modules/product/views/site/_product-m', [
//			'products' => $products,
			'loader' => true,
		]);
	}





}