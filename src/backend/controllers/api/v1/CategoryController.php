<?php

namespace yiicom\catalog\backend\controllers\api\v1;

use Yii;
use yii\helpers\Html;
use yii\web\ServerErrorHttpException;
use yiicom\backend\base\ApiController;
use yiicom\common\traits\ModelTrait;
use yiicom\content\common\grid\UrlAliasColumn;
use yiicom\catalog\common\models\Category;
use yiicom\catalog\common\models\CategoryFinder;
use yiicom\catalog\common\category\CategoryList;
use yiicom\catalog\backend\models\CategorySearch;
use yiicom\catalog\backend\forms\CategoryForm;

class CategoryController extends ApiController
{
    use ModelTrait;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->route = '#/catalog/category/index';

        return $this->renderPartial('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $this->getGridColumns(),
        ]);
    }

    /**
     * @return array
     */
    public function getGridColumns()
    {
        return [
            [
                'attribute' => 'id',
                'headerOptions' => ['class' => 'wpx-70'],
            ],
            [
                'attribute' => 'name',
                'format' => 'html',
                'value' => function (CategorySearch $model) {
                    $pattern = '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $spacer = $model->level ? str_repeat($pattern, $model->level) : '';

                    return "$spacer " . Html::a($model->name, ['/#/catalog/category/update', 'id' => $model->id], [
                        'title' => 'Редактировать'
                    ]);
                }
            ],
            [
                'attribute' => 'alias',
                'class' => UrlAliasColumn::class
            ],
            [
                'attribute' => 'title',
            ],
            [
                'attribute' => 'status',
                'filter' => (new Category)->statusesList(),
                'value' => function(Category $model) {
                    return (new Category)->statusesList()[$model->status];
                }
            ],
        ];
    }

    public function actionFind(int $id = null)
    {
        try {
            /* @var CategoryForm $model */
            $model = $this->findOrNewModel(CategoryForm::class, $id);

            if ($model->isNewRecord) {
                $model->parentId = (new CategoryFinder)->findRoot()->id ?? null;
            }

            return $model;

        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage());
        }
    }

    public function actionSave()
    {
        try {
            /* @var CategoryForm $model */
            $id = Yii::$app->request->post('id');
            $model = $this->findOrNewModel(CategoryForm::class, $id);

            if ($model->loadAll(Yii::$app->request->post()) && $model->validateAll()) {
                if (! $model->process()) {
                    throw new ServerErrorHttpException(Yii::t("yiicom", "Can't save model"));
                }
            }

            return $model;

        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage());
        }
    }

    /**
     * @return array
     * @throws ServerErrorHttpException
     */
    public function actionDelete()
    {
        try {
            /* @var CategoryForm $model */
            $id = Yii::$app->request->post('id');
            $model = $this->findModel(CategoryForm::class, $id);

            if ($model->delete()) {
                return ['status' => 'success'];
            }

            throw new ServerErrorHttpException(Yii::t("yiicom", "Can't delete model"));

            // Удаляет все связи товара с категорией и ее вложенными подкатегориями
            // TODO: add category delete
            // TODO: добавить транзакцию, удаление детей в один запрос
            // TODO: удаление урлов
//		ProductCategory::deleteAll('categoryId = :categoryId', [':categoryId' => $model->id]);
//		$childrens = $model->children()->all();
//		foreach($childrens as $child) {
//			ProductCategory::deleteAll('categoryId = :categoryId', [':categoryId' => $child->id]);
//		}
//
//		$model->deleteWithChildren();



        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage());
        }
    }

    public function actionList(bool $root = false, int $id = null)
    {
        return (new CategoryList($root, $id))->get();
    }

}
