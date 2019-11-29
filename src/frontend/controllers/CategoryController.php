<?php

namespace yiicom\catalog\frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yiicom\common\base\Controller;
use yiicom\content\common\models\Page;
use yiicom\content\frontend\traits\SitePageTrait;
use yiicom\catalog\common\models\Category;
use yiicom\catalog\common\models\Product;
//use app\modules\attribute\models\Attribute;

class CategoryController extends Controller
{
    use SitePageTrait;

	public function actionIndex($id)
	{
//	    echo '<pre>$id '; print_r($id);echo '</pre>';
//		$page = $this->findModel(Page::class, $id);
//
//		$category = Category::findOne(['level' => 0]);
//        $this->setMetaParams($category);

        $category = $this->loadModel(Category::class, $id);

//echo '<pre>$category'; print_r($category);echo '</pre>';
		return $this->render('index', [
//            'page' => $page,
			'category' => $category,
		]);
	}


	public function actionView($id)
	{
		$category = Category::getById($id);

		if(!$category) {
			throw new NotFoundHttpException;
		}

        $this->setPageParams($category);

		$products = Product::getProducts([
			'categoryId' => $category->getAllChildIds(),
		]);

		return $this->render('view', [
			'category' => $category,
			'products' => $products,
//			'attributes' => Attribute::getList(),
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