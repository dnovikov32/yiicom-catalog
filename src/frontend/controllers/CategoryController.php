<?php

namespace yiicom\catalog\frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yiicom\common\base\Controller;
use yiicom\content\common\models\Page;
use yiicom\content\frontend\traits\SitePageTrait;
use yiicom\catalog\common\models\Category;
use yiicom\catalog\common\models\CategoryFinder;
use yiicom\catalog\common\models\Product;
//use app\modules\attribute\models\Attribute;


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
        $categoryChildrenIds = (new CategoryFinder())->findChildren($category)->ids();
        $categoryIds = array_merge([$category->id], $categoryChildrenIds);

//        echo '<pre>'; print_r( (new CategoryFinder())->findChildren($category)->all() );echo '</pre>';exit;

        echo '<pre>current '; print_r($category->id);echo '</pre>';
        echo '<pre>child: '; print_r($categoryChildrenIds);echo '</pre>';

        echo '<pre>all: '; print_r(array_merge([$category->id], $categoryChildrenIds));echo '</pre>';
        exit;
        $products = (new ProductFinder())
            ->findByCategory($categoryIds)
            ->all();


//        $products = Product::find()
//            ->byCategory($categoryIds)
//            ->all();

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