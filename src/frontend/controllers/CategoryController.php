<?php
namespace app\modules\category\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yiicom\content\common\models\Page;
use yiicom\catalog\common\models\Category;
//use app\modules\attribute\models\Attribute;
use yiicom\catalog\common\models\Product;

class CategoryController extends \app\modules\site\components\SiteController
{
	public function actionIndex($id)
	{
		$page = $this->findModel($id, Page::className());
		$this->setPageParams($page);

		$category = Category::findOne(['level' => 0]);

		return $this->render('index', [
            'page' => $page,
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